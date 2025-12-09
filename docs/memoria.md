# Memória da Sessão - Correção de Rotas SaaS

**Data**: 2025-12-08
**Contexto**: Migração de subdomain-based (`empresa.dominio.com`) para path-based (`localhost:8000/app/empresa`)

---

## Estrutura de URLs Definida

| Ambiente | URL | Descrição |
|----------|-----|-----------|
| **Local** | `localhost:8000` | Landing page |
| **Local** | `localhost:8000/app/login` | Login |
| **Local** | `localhost:8000/app/{empresa}` | Dashboard da empresa |
| **Local** | `localhost:8000/meuadmin` | Painel super admin |
| **Prod** | `dominio.com` | Landing page |
| **Prod** | `app.dominio.com/{empresa}` | Dashboard (futuro) |

---

## Arquivos Modificados

### 1. `.env`
```diff
- APP_URL=http://localhost
+ APP_URL=http://localhost:8000

- SESSION_DOMAIN=.127.0.0.1.nip.io
+ SESSION_DOMAIN=
```

### 2. `app/Http/Controllers/OnboardingController.php`
```diff
- return redirect('/app');
+ return redirect("/app/{$company->slug}");
```

### 3. `app/Http/Responses/LogoutResponse.php`
```diff
- $url = "{$scheme}://{$domain}{$portSuffix}/?logout=1";
- return redirect($url);
+ $appUrl = config('app.url');
+ return redirect($appUrl . '/?logout=1');
```

### 4. `app/Filament/App/Pages/Tenancy/EditCompanyProfile.php`

**CNPJ com validação unique:**
```php
TextInput::make('cnpj')
    ->mask('99.999.999/9999-99')
    ->unique('companies', 'cnpj', ignoreRecord: true)
    ->validationMessages([
        'unique' => 'Este CNPJ já está cadastrado em outra empresa.',
    ])
```

**Campo slug com prefixo correto:**
```php
TextInput::make('slug')
    ->label('URL do Sistema')
    ->required()
    ->prefix(config('app.url') . '/app/')  // Era: ->suffix('.' . config('app.domain'))
    ->unique('companies', 'slug', ignoreRecord: true)
```

**Redirect após salvar:**
```php
protected function getRedirectUrl(): ?string
{
    // Sempre redireciona para o dashboard do tenant (com novo slug se alterado)
    return config('app.url') . '/app/' . $this->tenant->slug;
}
```

### 5. `app/Filament/App/Pages/Tenancy/RegisterCompany.php`
```diff
- ->prefix('/app/')
- ->helperText('Sua empresa ficará acessível em: /app/seu-slug')
+ ->prefix(config('app.url') . '/app/')
+ ->helperText('Sua empresa ficará acessível nesta URL')
```

---

## Problemas Resolvidos

1. ✅ **Erro CSRF "Page expired"** - SESSION_DOMAIN estava com nip.io
2. ✅ **Redirect sem tenant** - OnboardingController ia para `/app` sem slug
3. ✅ **Logout incorreto** - Usava lógica de subdomínio
4. ✅ **CNPJ duplicado = erro 500** - Agora valida com mensagem amigável
5. ✅ **Campo slug com suffix errado** - Agora mostra prefixo da URL completa
6. ✅ **Não redirecionava após salvar** - getRedirectUrl retornava null

---

## Configuração para Produção

No `.env` de produção, adicionar:
```env
APP_URL=https://dominio.com
FILAMENT_APP_DOMAIN=app.dominio.com
SESSION_DOMAIN=.dominio.com
```

---

## Próximos Passos (Pendentes)

- [ ] Testar fluxo completo de criação/edição de empresa
- [ ] Configurar para produção com subdomínio
- [ ] Verificar se outras páginas precisam de ajustes

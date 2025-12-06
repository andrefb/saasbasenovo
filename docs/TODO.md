# 📋 TODO - Melhorias Futuras

**Data de criação:** 06/12/2025  
**Projeto:** saas-core  
**Status:** Pendente para implementação futura

---

# ☁️ CLOUDINARY - MELHORIAS

## Migrar para Upload Direto (Opção A)

**Quando implementar:** Quando tiver galeria de fotos de empreendimentos ou muitos uploads.

**Benefícios:**
- Upload direto do navegador para Cloudinary
- Não consome banda do servidor
- Mais rápido para imagens grandes
- Mais escalável

**O que fazer:**
1. Criar "upload preset" no Cloudinary (unsigned)
2. Limitar tipos de arquivo e tamanho no preset
3. Implementar upload via JavaScript no frontend
4. Backend recebe apenas a URL final

**Código de referência:**
```javascript
const uploadDireto = async (file) => {
  const formData = new FormData();
  formData.append('file', file);
  formData.append('upload_preset', 'seu-preset');
  
  const res = await fetch(
    'https://api.cloudinary.com/v1_1/seu-cloud/upload',
    { method: 'POST', body: formData }
  );
  return res.json();
};
```

---

# 🔐 SEGURANÇA

## HTTPS em Produção

### O que fazer:
- Configurar certificado SSL com Let's Encrypt
- Forçar redirect HTTP → HTTPS no Nginx
- Configurar HSTS (Strict Transport Security)

### Configuração Nginx:
```nginx
server {
    listen 80;
    server_name seudominio.com *.seudominio.com;
    return 301 https://$host$request_uri;
}

server {
    listen 443 ssl http2;
    server_name seudominio.com *.seudominio.com;
    
    ssl_certificate /etc/letsencrypt/live/seudominio.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/seudominio.com/privkey.pem;
    
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
}
```

### Comando para gerar certificado:
```bash
sudo certbot --nginx -d seudominio.com -d *.seudominio.com
```

---

## 📝 Logging e Auditoria

### O que fazer:
- Instalar pacote spatie/laravel-activitylog
- Logar tentativas de login (sucesso/falha)
- Logar mudanças em dados sensíveis
- Logar acessos ao painel admin

### Instalação:
```bash
composer require spatie/laravel-activitylog
php artisan vendor:publish --provider="Spatie\Activitylog\ActivitylogServiceProvider" --tag="activitylog-migrations"
php artisan migrate
```

### Uso:
```php
activity()
    ->performedOn($model)
    ->causedBy(auth()->user())
    ->log('Ação realizada');
```

---

## 🔑 Password Policies

### O que fazer:
- Exigir senhas fortes no registro e troca de senha
- Verificar se senha está em listas de vazamento

### Implementação:
```php
use Illuminate\Validation\Rules\Password;

'password' => [
    'required',
    'confirmed',
    Password::min(8)
        ->letters()
        ->mixedCase()
        ->numbers()
        ->symbols()
        ->uncompromised(), // Verifica HaveIBeenPwned
],
```

---

## 🛡️ Proteção do Painel Admin

### O que fazer:
- Implementar IP allowlist para /meuadmin
- Adicionar 2FA (autenticação de dois fatores)

### IP Allowlist:
```php
// Middleware para verificar IP
$allowedIps = explode(',', config('app.admin_allowed_ips', ''));

if (!empty($allowedIps[0]) && !in_array($request->ip(), $allowedIps)) {
    abort(403, 'IP não autorizado');
}
```

```env
ADMIN_ALLOWED_IPS=177.x.x.x,189.x.x.x
```

### 2FA:
- Instalar pacote filament/spatie-laravel-permission ou similar
- Ou usar Google Authenticator com pragmarx/google2fa

---

## 🌐 Cloudflare

### O que configurar:
1. **SSL/TLS**: Modo "Full (strict)"
2. **Always Use HTTPS**: Ativar
3. **HSTS**: Ativar com includeSubDomains
4. **Bot Fight Mode**: Ativar
5. **Rate Limiting**: Criar regra para /login (5 req/min)
6. **Firewall Rules**: Bloquear países suspeitos se necessário

### Page Rules sugeridas:
- `*seudominio.com/meuadmin*` → Security Level: High
- `*seudominio.com/*` → Cache Level: Standard

---

## 🛑 Proteção DDoS

### Camadas de proteção:

1. **Cloudflare (CDN/WAF)**
   - Ativar "Under Attack Mode" quando necessário
   - Usar Challenge (CAPTCHA) para IPs suspeitos

2. **Nginx Rate Limiting**
```nginx
http {
    limit_conn_zone $binary_remote_addr zone=conn_limit:10m;
    limit_conn conn_limit 20;
    
    limit_req_zone $binary_remote_addr zone=req_limit:10m rate=10r/s;
    limit_req zone=req_limit burst=20 nodelay;
}
```

3. **Fail2Ban** (banir IPs após múltiplas falhas)
```bash
sudo apt install fail2ban
# Configurar jail para Nginx/SSH
```

---

## 🔍 Descoberta de Rotas

### O que fazer:
1. Desabilitar debug em produção
```env
APP_DEBUG=false
APP_ENV=production
```

2. Ocultar headers que revelam tecnologia
```nginx
# nginx.conf
server_tokens off;
more_clear_headers 'X-Powered-By';
```

3. Customizar páginas de erro (404, 500)
```
resources/views/errors/404.blade.php
resources/views/errors/500.blade.php
```

4. Não expor rotas desnecessariamente
```bash
# Nunca rodar em produção:
php artisan route:list
```

---

## 🚨 Checklist Final de Produção

### Antes de ir para produção, verificar:

- [ ] `APP_DEBUG=false`
- [ ] `APP_ENV=production`
- [ ] HTTPS configurado e funcionando
- [ ] Cloudflare ativado
- [ ] Backups automáticos do banco
- [ ] Rate limiting no Nginx
- [ ] Fail2Ban configurado
- [ ] Logs sendo salvos corretamente
- [ ] Monitoramento de uptime (UptimeRobot, etc)

---

*Arquivo criado para referência futura. Revisar periodicamente.*

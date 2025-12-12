# Últimas Mudanças - Deploy para Produção

## 2025-12-12

### Adicionar campo Descrição em Developments e Units

**Migração criada:** `2025_12_12_130316_add_description_to_developments_and_units_tables.php`

**Comandos para rodar no servidor:**
```bash
cd /var/www/saas-core
php artisan migrate
php artisan optimize:clear
```

### Correção do título do Lightbox na tabela pública

**Arquivo modificado:** `resources/views/public/tabela.blade.php`
- Removido prefixo "Unidade" do título do lightbox para exibir corretamente "Visão do Empreendimento"

**Comando para deploy:**
```bash
cd /var/www/saas-core
git pull origin main
php artisan view:clear
```

### Exibição da Descrição do Empreendimento na Tabela Pública

**Arquivos modificados:**
- `resources/views/public/tabela.blade.php` - Exibe descrição formatada
- `resources/css/public.css` - Estilo da descrição

### Campo Website do Empreendimento

**Migração criada:** `2025_12_12_131026_add_website_to_developments_table.php`

**Arquivos modificados:**
- `app/Models/Development.php` - Adicionado `website` no fillable
- `app/Filament/App/Resources/Developments/Schemas/DevelopmentForm.php` - Campo no formulário
- `resources/views/public/tabela.blade.php` - Link clicável na tabela pública
- `resources/css/public.css` - Estilo do botão de link

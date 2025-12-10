# Memória do Projeto: saas-core-new

> Este arquivo é lido automaticamente para dar contexto às conversas.

---

## Ambiente

- **OS:** Windows 11 logaod via wsl2 ubuntu
- **PHP:** 8.4 
- **Banco:** PostgreSQL 17

---

## Stack

- **Backend:** Laravel 12 + Filament v4 (mudou varias coisas em relação ao 3, sempre consultar)
- **Frontend :** Filament v4

---

## Filament v4 - MUDANÇAS IMPORTANTES

| v3 | v4 |
|----|----|
| `Forms\Components\...` | `Schemas\Components\...` |
| `->schema([...])` | `->components([...])` |
| `->actions([...])` | `->recordActions([...])` |
| `->bulkActions([...])` | `->toolbarActions([...])` |
| `Form::make()` | `Schema::make()` |

⚠️ Estrutura de pastas pode ser diferente do v3 — sempre consultar docs em caso de erros de importação.
⚠️ Ao sobrescrever classes, manter mesma estrutura do v4.

**Docs v4:** https://filamentphp.com/docs/4.x
| **Overview** | https://filamentphp.com/docs/4.x/panels/overview |
| **Schemas (novo!)** | https://filamentphp.com/docs/4.x/schemas/overview |
| **What's New** | https://filamentphp.com/content/leandrocfe-whats-new-in-filament-v4 |
| **Upgrade Guide** | https://filamentphp.com/docs/4.x/upgrade-guide |
| **Resources** | https://filamentphp.com/docs/4.x/panels/resources |

---

## Preferências de Código

- Responder em **português**
- Usar **UUID** para entidades de negócio
- Models com `use HasUuids;`
- Validações no **Form Request** (Laravel), não duplicar no frontend

---

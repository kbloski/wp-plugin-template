# WordPress Plugin Starter

Szablon pluginu WordPress z wykorzystaniem Composer i przestrzeni nazw (PSR-4).

---

## 📦 Instalacja

Aby poprawnie zainstalować plugin i uniknąć konfliktów między wieloma pluginami korzystającymi z Composer, wykonaj poniższe kroki:

### 1. Usuń istniejące pliki Composer (jeśli są)

Jeśli w katalogu pluginu znajdują się już pliki:

- `vendor/`
- `composer.lock`

należy je usunąć, ponieważ mogą zawierać konfliktujące dane z wcześniejszego buildu.


### 2. Zmień name w composer.json

W pliku composer.json upewnij się, że "name" jest unikalne dla każdego pluginu. To ważne, ponieważ Composer generuje nazwę klasy ComposerAutoloaderInit<hash> na podstawie tego pola. Taka sama nazwa w wielu 
pluginach spowoduje konflikt przy włączaniu.

{
  "name": "twojanazwa/my-unique-plugin",
  ...
}

### 3. Zainstaluj zależności Composer

Po upewnieniu się, że name jest unikalne i nie ma starych plików:

{
  "name": "twojanazwa/my-unique-plugin",
  ...
}

composer install


## ✅ Gotowe!
Teraz możesz używać przestrzeni nazw i klas zgodnie z konfiguracją PSR-4 w composer.json.


## 🛠️ Debugging
Aby włączyć debugowanie w WordPress, dodaj poniższy kod do pliku wp-config.php:

define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);


Author
Kamil Błoński
GitHub
Email
LinkedIn

License
This plugin is licensed under the GPLv2 or later.
Copyright (c) 2025 Kamil Błoński
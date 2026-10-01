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


## 🔌 Adaptery

Kod wtyczki nie woła bezpośrednio WordPressa ani bibliotek z `vendor/`. Wszystko, co zewnętrzne, wchodzi przez port (interfejs) z `include/Domain/Interfaces`, a jedyne miejsce, które zna hosta, to `include/Adapters/{System}`:

| Port | Adapter | Co obsługuje |
| --- | --- | --- |
| `HooksInterface` | `WordPress/HooksAdapter` | akcje, filtry, aktywacja / deaktywacja |
| `ShortcodesInterface` | `WordPress/ShortcodesAdapter` | rejestracja i renderowanie shortcode'ów |
| `OptionsStoreInterface` | `WordPress/OptionsStoreAdapter` | opcje wtyczki |
| `DatabaseInterface` | `WordPress/DatabaseAdapter` | zapytania, schemat tabel, transakcje |
| `RestInterface` | `WordPress/RestAdapter` | trasy REST (`ApiRequest` / `ApiResponse`) |
| `AssetsInterface` | `WordPress/AssetsAdapter` | kolejka skryptów i stylów |
| `AdminMenuInterface` | `WordPress/AdminMenuAdapter` | strony w menu wp-admin |
| `UsersInterface` | `WordPress/UsersAdapter` | zalogowany użytkownik, uprawnienia |
| `TranslatorInterface` | `WordPress/TranslatorAdapter` | katalog tłumaczeń, text domain |
| `EnvironmentInterface` | `WordPress/EnvironmentAdapter` | ścieżki i adresy URL |
| `EscaperInterface` | `WordPress/EscaperAdapter` | escapowanie HTML / URL / JSON |
| `LoggerInterface` | `Monolog/MonologLoggerAdapter` | logi |

Zasady:

- Adaptery są przypinane do portów w `include/DI/AppContainerProvider.php` — podmiana adaptera to zmiana jednej linii.
- Klasy z kontenera dostają porty w konstruktorze. Shortcode'y mają je pod `$this->hooks()`, `$this->shortcodes()`, `$this->escaper()`, a `Logger`, `PluginOptions`, `Translations`, `DbHelper` to statyczne fasady na porty.
- Handlery REST przyjmują `ApiRequest` i zwracają `ApiResponse` (błąd: `ApiResponse::error()`), nie znają `WP_REST_*`.
- Nowe klucze tłumaczeń dopisuje się w `TranslatorAdapter::all()` (gettext wymaga tam literałów).
- Integracja z kolejnym systemem (motyw, inna wtyczka, cache) = nowy interfejs w `Domain/Interfaces` + adapter w `include/Adapters/{System}` + wpis w kontenerze.
- Wyjątek: `index.php` i `uninstall.php` sprawdzają `ABSPATH` / `WP_UNINSTALL_PLUGIN`, bo tego wymaga WordPress.

## 🧪 Testy

    php tests/unit.php
    php tests/integration.php /ścieżka/do/wp-load.php

`unit.php` działa bez WordPressa: uruchamia całą wtyczkę na atrapach adapterów i pilnuje, żeby poza `include/Adapters` nie pojawiło się żadne wywołanie spoza PHP i własnego kodu. `integration.php` sprawdza prawdziwe adaptery na aktywnej wtyczce (po sobie sprząta).

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
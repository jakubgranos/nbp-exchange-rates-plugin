# Api Nbp rates plugin

## Treść zadania

Wymagania: Zastosować OOP, autoloader z Composer, opcjonalnie Testy Jednostkowe (WP_Mock)

Wykorzystując dane w formacie XML z api http://api.nbp.pl/ w panelu administracyjnym na podstronie Wpisy->Tagi pod tabelą zawierającą tagi
wyświetlać zawsze aktualnie obowiązującą cenę złota oraz aktualnie obowiązujący kurs średni każdej z trzech walut: Euro, Funty Brytyjskie,
Dolary Amerykańskie. Dodatkowo umożliwić filtrowanie pobranych wartości cen walut i złota (filter hook Wordpress Plugin API)
przed ich wyświetleniem.

## Installation

Two options for installation,

1. First option:
   download ZIP folder and drop it into plugins at wp-admin/plugin-install.php and click upload plugin

2. Secondary option:

-   Clone the repository

    ```sh
    git clone <repository-url>

    ```

-   Navigate to the plugin directory cd <plugin-directory>
-   Install dependencies using Composer:
    composer install
-   Activate the plugin in the WordPress admin panel.
-   Have fun!

## Usage

After activating the plugin, it will fetch and display NBP rates in the admin interface under the "Posts -> Tags" page.

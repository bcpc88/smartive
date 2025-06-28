# Instalacja i uruchomienie aplikacji

Konsolowa aplikacja napisana w Symfony, służąca do generowania miniaturek obrazów z lokalnego systemu plików i przesyłania ich na FTP lub zapis lokalny. Aplikacja oparta jest o architekturę heksagonalną i wykorzystuje Symfony Messenger oraz Redis do kolejkowania zadań.

## 🔧 Instalacja

- sklonuj repo i wejdź do katalogu z projektem: **https://github.com/bcpc88/smartive.git**
- uruchom dockery: **docker-compose up -d --build**
- skonfiguruj połączenie FTP do hosta lokalnego lub innego w .env
- wejdź do dockera php: **docker exec -it smartive-phpfpm bash** i uruchom composer: **composer install**

## 🔧 Uruchomienie

- po instalacji, z poziomu dockera php używamy komendy: **bin/console app:generate-thumbs /ścieżka/do/obrazów /ścieżka/docelowa**
- domyślnie program działa na lokalnym systemie plików
- dodatkowe opcje: **--type=ftp** - uruchamia możliwość generowania plików docelowo na skonfigurowany wcześniej serwer FTP
- uruchom worker: **bin/console messenger:consume generate_thumbs** żeby wygenerować miniatury
- przykładowe obrazy załączone w katalogu "test_images"

## 👤 Autor

Bartłomiej Ćwiertnia - rekrutacja Smartive.app

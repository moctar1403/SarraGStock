### ===========================
### DEPLOIEMENT COMPLET
### Laravel + PHPDesktop + MariaDB Portable
### ===========================

$LaravelPath     = "C:\wamp64\www\SarraGStock"
$PhpDesktopWWW   = "C:\Users\PC16\Desktop\SarraGstock\phpdesktop\www"
$MariaDBPath     = "C:\Users\PC16\Desktop\SarraGstock\mariadb"
$SQLFile         = "C:\Users\PC16\Desktop\SarraGstock\sql\gestock1.sql"
$DBName          = "gestock1"
$DBPort          = 3311

Write-Host "`n==== Déploiement en cours... ====`n" -ForegroundColor Cyan

### ----------------------------
### 1) Nettoyer dossier PHPDesktop
### ----------------------------
Write-Host "[1/7] Nettoyage de www..." -ForegroundColor Yellow
Get-ChildItem -Path $PhpDesktopWWW -Recurse -Force | Remove-Item -Recurse -Force

### ----------------------------
### 2) Copier Laravel (sauf vendor)
### ----------------------------
Write-Host "[2/7] Copie du projet Laravel..." -ForegroundColor Yellow
robocopy $LaravelPath $PhpDesktopWWW /MIR /XD "vendor" "node_modules" ".git"

### ----------------------------
### 3) Copier vendor
### ----------------------------
Write-Host "[3/7] Copie du dossier vendor..." -ForegroundColor Yellow
robocopy "$LaravelPath\vendor" "$PhpDesktopWWW\vendor" /MIR

### ----------------------------
### 4) Configuration MariaDB Portable
### ----------------------------
$MariaDBData = "$MariaDBPath\data"
$MariaDBBin  = "$MariaDBPath\bin"

# - Initialisation si data n’existe pas
if (!(Test-Path "$MariaDBData\mysql")) {
    Write-Host "[4/7] Initialisation MariaDB portable..." -ForegroundColor Yellow
    & "$MariaDBBin\mariadb-install-db.exe" --datadir="$MariaDBData" | Out-Null
}

### ----------------------------
### 5) Démarrer MariaDB en background
### ----------------------------
Write-Host "[5/7] Démarrage MariaDB..." -ForegroundColor Yellow

Start-Process -FilePath "$MariaDBBin\mysqld.exe" `
    -ArgumentList "--datadir=$MariaDBData --port=$DBPort" `
    -WindowStyle Hidden

Start-Sleep -Seconds 3

### ----------------------------
### 6) Importer Base de données
### ----------------------------
Write-Host "[6/7] Importation de la base..." -ForegroundColor Yellow

# - Créer la base si elle n’existe pas
& "$MariaDBBin\mysql.exe" -u root -P $DBPort -e "CREATE DATABASE IF NOT EXISTS $DBName;"

# - Importer SQL
& "$MariaDBBin\mysql.exe" -u root -P $DBPort $DBName < $SQLFile

### ----------------------------
### 7) Mise à jour du .env
### ----------------------------
Write-Host "[7/7] Mise à jour du .env..." -ForegroundColor Yellow

$envFile = "$PhpDesktopWWW\.env"

# mettre à jour DB_CONNECTION
(Get-Content $envFile) `
    -replace "^DB_CONNECTION=.*", "DB_CONNECTION=mysql" `
    -replace "^DB_HOST=.*", "DB_HOST=127.0.0.1" `
    -replace "^DB_PORT=.*", "DB_PORT=$DBPort" `
    -replace "^DB_DATABASE=.*", "DB_DATABASE=$DBName" `
    -replace "^DB_USERNAME=.*", "DB_USERNAME=root" `
    -replace "^DB_PASSWORD=.*", "DB_PASSWORD=" |
    Set-Content $envFile

### ----------------------------
### 8) Optimiser Laravel
### ----------------------------
Write-Host "Optimisation Laravel..."

cd $PhpDesktopWWW
php artisan optimize:clear
php artisan optimize

Write-Host "`n🎉 Déploiement terminé avec succès !" -ForegroundColor Green

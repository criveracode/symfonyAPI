# symfonyAPI
Proyecto Symfony 6

# Instalamos las dependencias
    % composer install

# Creamos la base de datos
    % php bin/console doctrine:database:create

# Migramos las tablas
    % php bin/console doctrine:migration:migrate

# Datos de ejemplo
    % php bin/console doctrine:fixtures:load
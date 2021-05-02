# Billetera Digital Api rest

Este projecto fue realizado para una prueba tecnica como requisito para aplicar a una bacante como desarrollador full stack, el mismo esta desarrollado en Laravel y sirve como puente entre el backend SOAP y el frontend en React.

## Como utilizar este projecto en local

Se deben seguir los suiguientes pasos: 
1. Clonar de GitHub
2. Instalar todas la dependencias: composer install, composer update
3. Usar un servidor local con apache y configurar el host Virtual(recomendado billeteraapirest.test)
4. Configurar el .env con la url del dominio( virtual local), no es necesario configurar nada relacionado con la base de datos(No se usa)
5. Si ha escogido una url diferente a la recomendada en el ApiSoap, debera ingresar en los archivos AuthController y TransaccionController y editar las urls en sus constructores(funciones)
6. Para probarlo se puede hacer uso del postman o usar las pruebas incluidas, se debe tener en funcionamiento el backend soap
7. Utilizarlo

## Mas información

Si deseas obtener mas información acerca de este projecto contactame a cristiangt9@gmail.com
@echo off
php artisan backup:run

if %ERRORLEVEL% equ 0 (
    echo MsgBox "Backup completed successfully!", 0, "Success" > temp.vbs
) else (
    echo MsgBox "Backup failed. Please check the logs.", 0, "Error" > temp.vbs
)
cscript //nologo temp.vbs
del temp.vbs

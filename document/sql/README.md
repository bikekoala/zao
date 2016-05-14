# How to export database structure?

``` bash
    mysqldump --opt --extended-insert -u root -p -d zao \
        programs \
        program_participant \
        participants \
        audios \
        comments \
        heres \
        admins \
        notifications \
        | sed 's/AUTO_INCREMENT=[0-9]*\s//g' > zao.sql
```

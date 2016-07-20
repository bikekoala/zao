# How to export database structure?

``` bash
    mysqldump --opt --extended-insert -u root -p -d zao \
        programs \
        program_participant \
        program_music \
        program_artist \
        participants \
        audios \
        musics \
        music_artist \
        artists \
        comments \
        heres \
        users \
        admins \
        notifications \
        | sed 's/AUTO_INCREMENT=[0-9]*\s//g' > zao.sql
```

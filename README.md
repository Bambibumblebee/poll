# poll

Hääletuse leht

Pealehel /index.php (adminile) on küsimus, millele saab ühe IP pealt vastata vaid ühe korra.
Seal lehel näeb tulemusi.
saab luua uusi hääletusi, millel on 2 või kolm vastusevarianti.
Lisaks saab kustutada olemasolevaid.

Rakenduse seadistamiseks tuleb config.php failis ära muuta host, username, password ja andmebaasi nimi ja sama teha ka functions.php failis.
Lisaks tuleb questions.sql failis seadistada ära andmebaasi nimi, kuhu tabel luuakse.
Peale seda minna /install.php ning seejärel saab minna /index.php lehele.

Vastajale tuleb jagada lehte /poll.php.
Seal saav vastaja vaata tulemusi ning vastata hääletusele.

Lehte saab testida siin https://kadi.kehtnakhk.ee/tak20_poll/index.php (admin)
Vastajale https://kadi.kehtnakhk.ee/tak20_poll/poll.php

Baasis on lisaks failid millel on juures märge _test need on hilisemaks edasiarenduseks.

#!/bin/bash
cd /your/forder/path
python ../scripts/crawler_eyny_lastest_movie.py >> /tmp/eyny_movie.log
php ../scripts/check_eyny_movie.php >> /tmp/check_eyny_movie.log

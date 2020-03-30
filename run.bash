#!/bin/bash

YOUR_DOGECOIN_SERVER="root@dime.cash"
. ./dcovid-19.public.broadcast-37534478785.3886
dcovid-19.public.broadcast > $$
T=$(php ./sendmany.php $$ | ssh $YOUR_DOGECOIN_SERVER "dd of=cast; . ./cast" )
echo $T | tee -a ./transactions.txt
rm $$

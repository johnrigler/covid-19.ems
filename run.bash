#!/bin/bash

YOUR_DOGECOIN_SERVER="root@dime.cash"
YOUR_LOCAL_DIR="/home/john/covid-19.ems"
. $YOUR_LOCAL_DIR/dcovid-19.public.broadcast
dcovid-19.public.broadcast > $$
T=$(php $YOUR_LOCAL_DIR/sendmany.php $$ | ssh $YOUR_DOGECOIN_SERVER "dd of=cast; . ./cast" )
echo $T | tee -a $YOUR_LOCAL_DIR/transactions.txt
rm $$

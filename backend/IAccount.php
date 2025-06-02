<?php
    interface IAccount {
        function add_balance($conn, float $value_to_add);
        function withdraw($conn, float $value_to_withdraw);
    }
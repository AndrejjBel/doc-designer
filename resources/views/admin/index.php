<?php
insertTemplate('/templates/admin/header', ['data' => $data]);
insertTemplate('/templates/admin/navbar', ['data' => $data]);
insertTemplate('/templates/admin/leftside-menu', ['data' => $data]);
insertTemplate('/templates/admin/content/' . $data['temp'], ['data' => $data]);
insertTemplate('/templates/admin/footer', ['data' => $data]);

<?php include_once "app-style.php" ?>

<div class="app">
    <h1 class="app__heading">Alpine + php</h1>
    <button class="app__button" x-data="{count: 0}" @click="count++">
        Count: <span x-text="count"></span>
    </button>
</div>
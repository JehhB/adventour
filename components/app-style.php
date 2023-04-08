<style>
.app {
    font-family: sans-serif;
    display: flex;
    flex-direction: column;
    width: 100vw;
    height: 100vh;
    align-items: center;
    justify-content: center;
}

.app__button {
    border: 1px solid black;
    background-color: blue;
    font-weight: 600;
    font-size: 1rem;
    padding: 4px 8px;
    color: white;
    box-shadow: 3px 3px 0px black;
}

.app__button:active {
    box-shadow: 1px 1px 0px black;
    transform: translate(2px, 2px);
}
</style>
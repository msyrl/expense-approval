if ("serviceWorker" in navigator) {
    window.addEventListener("load", async () => {
        try {
            const register = await navigator.serviceWorker.register(
                "/service-worker.js"
            );

            await navigator.serviceWorker.ready;
        } catch (error) {
            console.log(error);
        }
    });
}

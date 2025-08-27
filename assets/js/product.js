document.addEventListener("DOMContentLoaded", () => {
    const addBtn = document.getElementById("add-to-cart-btn");
    const quantityInput = document.getElementById("product-quantity");

    addBtn?.addEventListener("click", async () => {
        const gameId = addBtn.dataset.gameId;
        const quantity = quantityInput.value;

        try {
            const response = await fetch("/Project_Web_Aout/api/panier.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    action: "update",
                    game_id: gameId,
                    quantity: quantity
                })
            });

            const data = await response.json();
            if (data.success) {
                window.location.href = "/Project_Web_Aout/index.php?page=panier";
            } else {
                alert(data.error || "Erreur lors de l'ajout au panier.");
            }
        } catch (e) {
            console.error("Erreur AJAX:", e);
        }
    });
});

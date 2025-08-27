document.addEventListener("DOMContentLoaded", () => {
    const quantitySelects = document.querySelectorAll(".quantity-select");
    const totalPriceEl = document.getElementById("total-price");
    const clearBtn = document.getElementById("clear-btn");
    const checkoutBtn = document.getElementById("checkout-btn");

    // Mise à jour de la quantité
    quantitySelects.forEach(select => {
        select.addEventListener("change", async () => {
            const gameId = select.dataset.gameId;
            const newQuantity = select.value;

            try {
                const response = await fetch("/Project_Web_Aout/api/panier.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        action: "update",
                        game_id: gameId,
                        quantity: newQuantity
                    })
                });
                const data = await response.json();
                if (data.success) {
                    // maj du sous-total
                    const subtotalEl = document.getElementById(`subtotal-${gameId}`);
                    if (subtotalEl) subtotalEl.textContent = data.subtotal.toFixed(2) + " €";
                    // maj du total
                    totalPriceEl.textContent = data.total.toFixed(2) + " €";
                } else {
                    alert(data.error || "Erreur lors de la mise à jour du panier.");
                }
            } catch (e) {
                console.error("Erreur AJAX:", e);
            }
        });
    });

    clearBtn?.addEventListener("click", async () => {
        const response = await fetch("/Project_Web_Aout/api/panier.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "clear" })
        });

        const data = await response.json();
        if (data.success) {
            location.reload();
        }
    });

    checkoutBtn?.addEventListener("click", async () => {
        const response = await fetch("/Project_Web_Aout/api/panier.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ action: "checkout" })
        });

        const data = await response.json();
        if (data.success) {
            window.location.href = `index.php?page=order_summary&id=${data.order_id}`;
        } else {
            alert(data.error || "Erreur lors de la commande.");
        }
    });
});

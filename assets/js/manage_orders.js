document.addEventListener("DOMContentLoaded", () => {
    const deleteButtons = document.querySelectorAll(".delete-order-btn");

    deleteButtons.forEach(btn => {
        btn.addEventListener("click", async () => {
            const orderId = btn.dataset.orderId;

            if (!confirm(`Supprimer cette commande N°${orderId} ?`)) return;

            try {
                const response = await fetch("/Project_Web_Aout/api/manage_orders.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({ action: "delete", order_id: orderId })
                });

                const data = await response.json();

                if (data.success) {
                    const row = btn.closest("tr");
                    row.parentNode.removeChild(row);
                } else {
                    alert(data.error || "Erreur lors de la suppression.");
                }
            } catch (e) {
                console.error("Erreur AJAX:", e);
            }
        });
    });
});

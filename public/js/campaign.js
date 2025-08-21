document.addEventListener("DOMContentLoaded", () => {
    const campaignItems = document.querySelectorAll(".campaign-item");
    const modal = document.getElementById("campaignModal");
    const closeModal = document.getElementById("closeModal");

    const modalTitle = document.getElementById("modalTitle");
    const modalDesc = document.getElementById("modalDesc");
    const modalTarget = document.getElementById("modalTarget");
    const modalCollected = document.getElementById("modalCollected");
    const progressBar = document.getElementById("progressBar");

    campaignItems.forEach(item => {
        item.addEventListener("click", () => {
            const title = item.dataset.title;
            const desc = item.dataset.desc;
            const target = parseInt(item.dataset.target);
            const collected = parseInt(item.dataset.collected);

            modalTitle.textContent = title;
            modalDesc.textContent = desc;
            modalTarget.textContent = `Rp ${target.toLocaleString()}`;
            modalCollected.textContent = `Rp ${collected.toLocaleString()}`;
            progressBar.style.width = Math.min((collected / target) * 100, 100) + "%";

            modal.style.display = "flex";
            modal.setAttribute("aria-hidden", "false");
        });
    });

    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
        modal.setAttribute("aria-hidden", "true");
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
            modal.setAttribute("aria-hidden", "true");
        }
    });
});
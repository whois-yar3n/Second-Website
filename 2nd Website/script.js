

function formatTL(amount) {
    const s = Math.round(amount).toString();
    const withDots = s.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return withDots + " TL";
}

function setCookie(name, value, days) {
    const expires = new Date(Date.now() + days * 24 * 60 * 60 * 1000).toUTCString();
    document.cookie = `${name}=${encodeURIComponent(value)}; expires=${expires}; path=/; SameSite=Lax`;
}

function getCookie(name) {
    const prefix = `${name}=`;
    const cookies = document.cookie ? document.cookie.split("; ") : [];

    for (const cookie of cookies) {
        if (cookie.startsWith(prefix)) {
            return decodeURIComponent(cookie.slice(prefix.length));
        }
    }

    return "";
}

function saveViewedDevice(card) {
    const title = card.querySelector("h4")?.textContent?.trim();
    const meta = card.querySelector(".meta")?.textContent?.trim();

    if (!title || !meta) return;

    let history = [];

    try {
        history = JSON.parse(getCookie("viewed_devices") || "[]");
    } catch (error) {
        history = [];
    }

    const entry = {
        title,
        meta,
        viewedAt: new Date().toLocaleString("tr-TR")
    };

    const filtered = history.filter((item) => item.title !== title);
    filtered.unshift(entry);
    const limited = filtered.slice(0, 8);

    setCookie("viewed_devices", JSON.stringify(limited), 30);
}

function handleInspect(card) {
    const needsRepair = card.dataset.needsRepair === "true";
    const alreadyDiscounted = card.dataset.discounted === "true";

    const priceEl = card.querySelector(".price");
    const basePrice = Number(card.dataset.price || "0");

    if (!priceEl || !basePrice) return;

    if (needsRepair && !alreadyDiscounted) {
        const newPrice = basePrice * 0.75;
        priceEl.textContent = formatTL(newPrice);
        card.dataset.discounted = "true";

        const issue = card.dataset.issue;
        if (issue) {
            alert("İnceleme sonucu: " + issue + "\nFiyat %25 düşürüldü.");
        } else {
            alert("İnceleme sonucu: Tamir/değişim gerekiyor.\nFiyat %25 düşürüldü.");
        }
        return;
    }

    if (needsRepair && alreadyDiscounted) {
        alert("Bu ürün daha önce indirime girdi.");
        return;
    }

    alert("İnceleme sonucu: Belirgin bir sorun bulunmadı.");
}

document.addEventListener("DOMContentLoaded", async () => {
    const buttons = document.querySelectorAll(".inspect-btn");

    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const card = btn.closest(".card");
            if (!card) return;
            saveViewedDevice(card);
            handleInspect(card);
        });
    });

    // Fotoğraf linki değişikliği için satıcı oturumunu kontrol et
    let sellerLoggedIn = false;
    try {
        const res = await fetch("seller-status.php", { credentials: "same-origin" });
        if (res.ok) {
            const data = await res.json();
            sellerLoggedIn = Boolean(data?.loggedIn);
        }
    } catch (e) {
        // Hata durumunda güvenlik varsayımı: kilitli bırak
        sellerLoggedIn = false;
    }

    // Fotoğraf URL alanı yalnızca satıcı girişinde görünsün
    document.documentElement.classList.toggle("seller-logged-in", sellerLoggedIn);

    // Fotoğraf ekleme işlevselliği
    const photoAddBtns = document.querySelectorAll(".photo-add-btn");

    photoAddBtns.forEach((btn) => {
        const card = btn.closest(".card");
        const photoInput = card ? card.querySelector(".photo-input") : null;

        // Oturum yoksa link girişini ve butonu kilitle
        btn.disabled = !sellerLoggedIn;
        if (photoInput) {
            photoInput.disabled = !sellerLoggedIn;
        }

        btn.addEventListener("click", () => {
            if (!sellerLoggedIn) {
                alert("Satıcı girişi yapmadan fotoğraf linki ekleyemezsiniz.");
                return;
            }

            if (!card) return;
            if (!photoInput) return;
            const photoUrl = photoInput.value.trim();

            if (!photoUrl) {
                alert("Lütfen bir fotoğraf URL'si girin!");
                return;
            }

            // URL geçerliliğini kontrol et
            try {
                new URL(photoUrl);
            } catch (error) {
                alert("Lütfen geçerli bir URL girin!");
                return;
            }

            const img = card.querySelector(".product-image");
            const newImg = new Image();

            newImg.onload = () => {
                img.src = photoUrl;
                img.alt = "Ürün Fotoğrafı";
                photoInput.value = "";
                alert("Fotoğraf başarıyla eklendi!");
            };

            newImg.onerror = () => {
                alert("Fotoğraf yüklenemedi. Lütfen URL'yi kontrol edin!");
            };

            newImg.src = photoUrl;
        });
    });
});



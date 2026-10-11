tailwind.config = {
  darkMode: "class",
  theme: {
    extend: {
      colors: {
        "on-primary-fixed": "#001b3d",
        "surface-dim": "#cbdbf5",
        "surface-container-high": "#dce9ff",
        "on-error-container": "#93000a",
        "on-primary-container": "#85a9e8",
        "on-secondary": "#ffffff",
        secondary: "#0051d5",
        "on-error": "#ffffff",
        outline: "#737781",
        "on-tertiary-fixed": "#001e2c",
        "on-background": "#0b1c30",
        "surface-bright": "#f8f9ff",
        "on-tertiary": "#ffffff",
        "surface-variant": "#d3e4fe",
        "surface-container-lowest": "#ffffff",
        "on-tertiary-container": "#27b4ee",
        tertiary: "#002b3d",
        "tertiary-fixed": "#c4e7ff",
        "secondary-fixed-dim": "#b4c5ff",
        "on-primary": "#ffffff",
        "inverse-surface": "#213145",
        "on-secondary-container": "#fefcff",
        "on-secondary-fixed-variant": "#003ea8",
        "tertiary-fixed-dim": "#7bd0ff",
        "surface-tint": "#395f98",
        "primary-fixed-dim": "#a9c7ff",
        "error-container": "#ffdad6",
        primary: "#002753",
        "inverse-primary": "#a9c7ff",
        "on-surface-variant": "#434750",
        "inverse-on-surface": "#eaf1ff",
        "surface-container-highest": "#d3e4fe",
        "primary-fixed": "#d6e3ff",
        "surface-container": "#e5eeff",
        "on-tertiary-fixed-variant": "#004c69",
        "primary-container": "#0f3d75",
        "outline-variant": "#c3c6d1",
        error: "#ba1a1a",
        "on-primary-fixed-variant": "#1d477f",
        "secondary-fixed": "#dbe1ff",
        "secondary-container": "#316bf3",
        background: "#f8f9ff",
        "surface-container-low": "#eff4ff",
        surface: "#f8f9ff",
        "on-secondary-fixed": "#00174b",
        "on-surface": "#0b1c30",
        "tertiary-container": "#00425b",
      },
      borderRadius: {
        DEFAULT: "0.25rem",
        lg: "0.5rem",
        xl: "0.75rem",
        full: "9999px",
      },
      spacing: {
        "space-lg": "1.5rem",
        gutter: "1.5rem",
        "space-xl": "2rem",
        "space-sm": "0.5rem",
        margin: "2rem",
        "margin-mobile": "1rem",
        "space-md": "1rem",
        "gutter-mobile": "1rem",
        "space-xs": "0.25rem",
      },
      fontFamily: {
        "body-sm": ["Inter"],
        "headline-sm": ["Plus Jakarta Sans"],
        "body-md": ["Inter"],
        "display-lg": ["Plus Jakarta Sans"],
        "label-sm": ["Inter"],
        "headline-lg-mobile": ["Plus Jakarta Sans"],
        "display-lg-mobile": ["Plus Jakarta Sans"],
        "label-md": ["Inter"],
        "headline-lg": ["Plus Jakarta Sans"],
        "label-lg": ["Inter"],
        "headline-md": ["Plus Jakarta Sans"],
        "body-lg": ["Inter"],
      },
      fontSize: {
        "body-sm": ["12px", { lineHeight: "16px", fontWeight: "400" }],
        "headline-sm": [
          "16px",
          { lineHeight: "24px", letterSpacing: "-0.005em", fontWeight: "600" },
        ],
        "body-md": ["14px", { lineHeight: "20px", fontWeight: "400" }],
        "display-lg": [
          "36px",
          { lineHeight: "44px", letterSpacing: "-0.02em", fontWeight: "700" },
        ],
        "label-sm": [
          "11px",
          { lineHeight: "14px", letterSpacing: "0.04em", fontWeight: "600" },
        ],
        "headline-lg-mobile": [
          "24px",
          { lineHeight: "32px", letterSpacing: "-0.015em", fontWeight: "700" },
        ],
        "display-lg-mobile": [
          "28px",
          { lineHeight: "36px", letterSpacing: "-0.02em", fontWeight: "700" },
        ],
        "label-md": [
          "12px",
          { lineHeight: "16px", letterSpacing: "0.02em", fontWeight: "600" },
        ],
        "headline-lg": [
          "30px",
          { lineHeight: "38px", letterSpacing: "-0.015em", fontWeight: "700" },
        ],
        "label-lg": [
          "14px",
          { lineHeight: "20px", letterSpacing: "0.01em", fontWeight: "600" },
        ],
        "headline-md": [
          "20px",
          { lineHeight: "28px", letterSpacing: "-0.01em", fontWeight: "600" },
        ],
        "body-lg": ["16px", { lineHeight: "24px", fontWeight: "400" }],
      },
    },
  },
};

const pageRoutes = {
  "trang-chu": "trang-chu.php",
  "trang-chu-tra-cuu": "trang-chu.php",
  "dat-lich": "dat-lich-hen.php",
  "dat-lich-hen": "dat-lich-hen.php",
  "dat-lich-sua-chua": "dat-lich-hen.php",
  "tra-cuu-tien-do": "tra-cuu-tien-do.php",
  "theo-doi-tien-do": "tra-cuu-tien-do.php",
  "so-bao-hanh-dien-tu": "thiet-bi-lich-su.php",
  "thiet-bi-lich-su": "thiet-bi-lich-su.php",
  "chi-nhanh-ho-tro": "tra-cuu-chi-nhanh.php",
  "tra-cuu-chi-nhanh": "tra-cuu-chi-nhanh.php",
};

function wireInternalLinks() {
  document.querySelectorAll("a[data-path]").forEach(function (link) {
    const target = pageRoutes[link.dataset.path];
    if (target) {
      link.setAttribute("href", target);
    }
  });
}

function applyAuthenticationPrivacy() {
  const isLoggedIn = localStorage.getItem("reliantcare_logged_in") === "true";

  document.querySelectorAll("[data-auth-private]").forEach(function (element) {
    element.classList.toggle("auth-private-hidden", !isLoggedIn);
  });

  document.querySelectorAll("[data-auth-blank]").forEach(function (element) {
    if (!element.dataset.authValue) {
      element.dataset.authValue = element.textContent;
    }
    element.textContent = isLoggedIn ? element.dataset.authValue : "";
  });

  document.querySelectorAll("[data-auth-guest]").forEach(function (element) {
    element.classList.toggle("auth-guest-hidden", isLoggedIn);
  });

  document
    .querySelectorAll('[data-auth-action="logout"]')
    .forEach(function (control) {
      control.setAttribute(
        "aria-label",
        isLoggedIn ? "Đăng xuất" : "Đăng nhập",
      );
      control.setAttribute("title", isLoggedIn ? "Đăng xuất" : "Đăng nhập");
      const icon = control.querySelector(".material-symbols-outlined");
      if (icon) {
        icon.textContent = isLoggedIn ? "logout" : "person";
      }
    });
}

function initAuthenticationControls() {
  document
    .querySelectorAll('[data-auth-action="logout"]')
    .forEach(function (control) {
      if (control.dataset.authBound) {
        return;
      }
      control.dataset.authBound = "true";
      control.addEventListener("click", function (event) {
        if (localStorage.getItem("reliantcare_logged_in") !== "true") {
          event.preventDefault();
          document.body.setAttribute("data-auth-gate", "");
          initAuthenticationGate();
          return;
        }

        event.preventDefault();
        fetch("auth.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ mode: "logout" }),
        }).finally(function () {
          localStorage.removeItem("reliantcare_logged_in");
          window.location.reload();
        });
      });
    });
}

function initWaveBackground() {
  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  document.addEventListener(
    "pointermove",
    function (event) {
      const shiftX = (event.clientX / window.innerWidth - 0.5) * 34;
      const shiftY = (event.clientY / window.innerHeight - 0.5) * 24;
      document.body.style.setProperty("--wave-x", `${shiftX}px`);
      document.body.style.setProperty("--wave-y", `${shiftY}px`);
    },
    { passive: true },
  );
}

function initAuthenticationGate() {
  const isLoggedIn = localStorage.getItem("reliantcare_logged_in") === "true";
  const pageNeedsAuthGate = document.body.hasAttribute("data-auth-gate");
  const hasDatabaseSession =
    document.body.classList.contains("has-database-view") ||
    document.body.classList.contains("has-database-tracking");

  if (hasDatabaseSession) {
    localStorage.setItem("reliantcare_logged_in", "true");
    applyAuthenticationPrivacy();
    return;
  }

  if (isLoggedIn || !pageNeedsAuthGate) {
    return;
  }

  const modal = document.createElement("div");
  modal.className = "auth-modal-backdrop";
  modal.innerHTML = `
    <section class="auth-modal" role="dialog" aria-modal="true" aria-labelledby="auth-modal-title">
      <button class="auth-modal-close" type="button" aria-label="Đóng">&times;</button>
      <div class="auth-modal-icon"><span class="material-symbols-outlined">lock</span></div>
      <h2 id="auth-modal-title">Đăng nhập tài khoản</h2>
      <p class="auth-modal-description">Đăng nhập để xem thông tin khách hàng, thiết bị và lịch sử sửa chữa.</p>
      <div class="auth-modal-tabs" role="tablist">
        <button class="auth-modal-tab is-active" type="button" data-auth-mode="login">Đăng nhập</button>
        <button class="auth-modal-tab" type="button" data-auth-mode="register">Đăng ký</button>
      </div>
      <div class="auth-social-actions">
        <button class="auth-social-button auth-google-button" type="button" data-auth-provider="google">
          <span class="auth-provider-mark">G</span>
          <span>Tiếp tục với Google</span>
        </button>
        <button class="auth-social-button auth-facebook-button" type="button" data-auth-provider="facebook">
          <span class="auth-provider-mark">f</span>
          <span>Tiếp tục với Facebook</span>
        </button>
      </div>
      <div class="auth-divider"><span>hoặc</span></div>
      <form class="auth-modal-form" data-auth-form>
        <label>Email hoặc tên tài khoản<input type="text" name="account" placeholder="Nhập email hoặc tên tài khoản" required></label>
        <label class="auth-register-field" hidden>Họ và tên<input type="text" name="full_name" placeholder="Nhập họ và tên"></label>
        <label class="auth-register-field" hidden>Số điện thoại<input type="tel" name="phone" placeholder="Nhập số điện thoại"></label>
        <label class="auth-password-field">Mật khẩu<input type="password" name="password" placeholder="Nhập mật khẩu" required></label>
        <label class="auth-register-field" hidden>Nhập lại mật khẩu<input type="password" name="password-confirm" placeholder="Nhập lại mật khẩu"></label>
        <button class="auth-modal-submit" type="submit">Đăng nhập</button>
      </form>
      <button class="auth-modal-continue" type="button">Tiếp tục không đăng nhập</button>
    </section>
  `;

  document.body.appendChild(modal);

  const closeModal = function () {
    modal.remove();
  };

  modal
    .querySelector(".auth-modal-close")
    .addEventListener("click", closeModal);
  modal
    .querySelector(".auth-modal-continue")
    .addEventListener("click", closeModal);
  modal.querySelectorAll("[data-auth-provider]").forEach(function (button) {
    button.addEventListener("click", function () {
      localStorage.setItem("reliantcare_logged_in", "true");
      applyAuthenticationPrivacy();
      closeModal();
    });
  });
  modal.addEventListener("click", function (event) {
    if (event.target === modal) {
      closeModal();
    }
  });

  modal.querySelectorAll("[data-auth-mode]").forEach(function (tab) {
    tab.addEventListener("click", function () {
      const isRegister = tab.dataset.authMode === "register";
      modal.querySelectorAll("[data-auth-mode]").forEach(function (item) {
        item.classList.toggle("is-active", item === tab);
      });
      modal.querySelectorAll(".auth-register-field").forEach(function (field) {
        field.hidden = !isRegister;
      });
      modal
        .querySelectorAll(".auth-register-field input")
        .forEach(function (input) {
          input.required = isRegister;
        });
      modal.querySelector(".auth-modal-submit").textContent = isRegister
        ? "Tạo tài khoản"
        : "Đăng nhập";
      modal.querySelector("#auth-modal-title").textContent = isRegister
        ? "Đăng ký tài khoản"
        : "Đăng nhập tài khoản";
    });
  });

  modal
    .querySelector("[data-auth-form]")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const registerField = modal.querySelector(".auth-register-field");
      const password = modal.querySelector('input[name="password"]');
      const passwordConfirm = modal.querySelector(
        'input[name="password-confirm"]',
      );
      if (!registerField.hidden && password.value !== passwordConfirm.value) {
        passwordConfirm.setCustomValidity("Mật khẩu nhập lại không khớp.");
        passwordConfirm.reportValidity();
        return;
      }
      passwordConfirm.setCustomValidity("");
      const formData = new FormData(event.currentTarget);
      const isRegister = !registerField.hidden;
      const payload = {
        mode: isRegister ? "register" : "login",
        account: formData.get("account"),
        password: formData.get("password"),
        full_name: formData.get("full_name"),
        phone: formData.get("phone"),
      };
      const submit = modal.querySelector(".auth-modal-submit");
      submit.disabled = true;
      fetch("auth.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload),
      })
        .then(function (response) {
          return response.json().then(function (data) {
            if (!response.ok || !data.success)
              throw new Error(data.message || "Không thể xác thực.");
            return data;
          });
        })
        .then(function () {
          localStorage.setItem("reliantcare_logged_in", "true");
          window.location.reload();
        })
        .catch(function (error) {
          submit.disabled = false;
          submit.insertAdjacentHTML(
            "afterend",
            '<p class="auth-error text-error text-sm mt-2"></p>',
          );
          modal.querySelector(".auth-error").textContent = error.message;
        });
    });
}

function switchLookupTab(type) {
  const tabs = {
    rma: document.getElementById("tab-rma"),
    phone: document.getElementById("tab-phone"),
    serial: document.getElementById("tab-serial"),
  };
  const input = document.getElementById("omni-search-input");

  for (const key in tabs) {
    if (tabs[key]) {
      tabs[key].className =
        "search-tab-btn flex items-center gap-1.5 px-space-md py-2 rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container hover:text-on-surface transition-all";
    }
  }

  if (tabs[type]) {
    tabs[type].className =
      "search-tab-btn flex items-center gap-1.5 px-space-md py-2 rounded-lg font-label-md text-label-md bg-primary text-on-primary shadow-sm transition-all";
  }

  if (type === "rma") {
    input.placeholder = "Nhập mã phiếu RMA (VD: RMA-2025-8892)...";
  } else if (type === "phone") {
    input.placeholder = "Nhập số điện thoại khách hàng (VD: 0918 456 789)...";
  } else if (type === "serial") {
    input.placeholder = "Nhập số Serial / IMEI thiết bị (VD: C02GG3VCMD6R)...";
  }
}

function clearSearchInput() {
  const input = document.getElementById("omni-search-input");
  input.value = "";
  input.focus();
}

function handleSearch(e) {
  e.preventDefault();
  const input = document.getElementById("omni-search-input");
  if (!input.value.trim()) {
    alert("Vui lòng nhập thông tin để tra cứu.");
    input.focus();
    return;
  }
  const resultArea = document.getElementById("lookup-results-section");
  if (resultArea) {
    resultArea.scrollIntoView({ behavior: "smooth" });
  }
}

function handleApprove() {
  const toast = document.getElementById("approval-success-toast");
  const btnApprove = document.getElementById("btn-approve");
  const step3 = document.getElementById("step-node-3");
  const step3Icon = document.getElementById("step-node-3-icon");
  const step3Badge = document.getElementById("step-node-3-badge");
  const step4 = document.getElementById("step-node-4");
  const step4Icon = document.getElementById("step-node-4-icon");
  const step4Badge = document.getElementById("step-node-4-badge");

  if (btnApprove) {
    btnApprove.disabled = true;
    btnApprove.className =
      "h-12 px-space-xl rounded-xl bg-emerald-600 text-on-primary font-label-lg text-label-lg font-bold transition-all flex items-center justify-center gap-2 cursor-not-allowed";
    btnApprove.innerHTML =
      '<span class="material-symbols-outlined text-[22px]">check</span><span>Đã duyệt báo giá!</span>';
  }

  if (toast) {
    toast.classList.remove("hidden");
  }

  // Cập nhật mốc 3: Hoàn tất
  if (step3) {
    step3.className =
      "flex flex-col gap-1.5 p-space-sm rounded-lg bg-emerald-50/70 border border-emerald-200 transition-all";
    if (step3Icon) {
      step3Icon.className =
        "w-7 h-7 rounded-full bg-emerald-600 text-on-primary flex items-center justify-center font-label-sm font-bold";
      step3Icon.innerHTML =
        '<span class="material-symbols-outlined text-[16px]">check</span>';
    }
    if (step3Badge) {
      step3Badge.className =
        "font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-bold";
      step3Badge.textContent = "Đã duyệt";
    }
  }

  // Cập nhật mốc 4: Đang xử lý
  if (step4) {
    step4.className =
      "flex flex-col gap-1.5 p-space-sm rounded-lg bg-secondary/10 border-2 border-secondary transition-all";
    if (step4Icon) {
      step4Icon.className =
        "w-7 h-7 rounded-full bg-secondary text-on-primary flex items-center justify-center font-label-sm font-bold";
    }
    if (step4Badge) {
      step4Badge.className =
        "font-label-sm text-label-sm px-2 py-0.5 rounded-full bg-secondary text-on-primary font-bold";
      step4Badge.textContent = "Đang xử lý";
    }
  }

  if (toast) {
    toast.scrollIntoView({ behavior: "smooth", block: "center" });
  }
}

function handleDecline() {
  const confirmDecline = confirm(
    "Bạn có chắc muốn từ chối phương án sửa chữa này?\\nThiết bị sẽ được lắp ráp lại nguyên trạng và không phát sinh bất kỳ khoản phí nào.",
  );
  if (confirmDecline) {
    alert(
      "Đã ghi nhận yêu cầu từ chối. Kỹ thuật viên sẽ đóng máy và gửi thông báo mời bạn nhận lại thiết bị.",
    );
  }
}

function initLookupPage() {
  document.querySelectorAll("[data-lookup-tab]").forEach(function (button) {
    button.addEventListener("click", function () {
      switchLookupTab(button.dataset.lookupTab);
    });
  });

  document
    .querySelectorAll('[data-action="clear-search"]')
    .forEach(function (button) {
      button.addEventListener("click", clearSearchInput);
    });

  document
    .querySelectorAll('[data-search-form="lookup"]')
    .forEach(function (form) {
      form.addEventListener("submit", handleSearch);
    });
}

function initRepairDecisionPage() {
  document
    .querySelectorAll('[data-action="approve-repair"]')
    .forEach(function (button) {
      button.addEventListener("click", handleApprove);
    });

  document
    .querySelectorAll('[data-action="decline-repair"]')
    .forEach(function (button) {
      button.addEventListener("click", handleDecline);
    });
}

function initBranchSupportPage() {
  // GPS Click Simulation
  const geoBtn = document.getElementById("btn-geolocation");
  if (geoBtn) {
    geoBtn.addEventListener("click", function () {
      const original = geoBtn.innerHTML;
      geoBtn.innerHTML =
        '<span class="material-symbols-outlined text-secondary text-[18px] animate-spin">sync</span><span>Đang định vị...</span>';
      setTimeout(function () {
        geoBtn.innerHTML =
          '<span class="material-symbols-outlined text-secondary text-[18px]">check_circle</span><span>Đã chọn: Keangnam (1.2km)</span>';
        setTimeout(function () {
          geoBtn.innerHTML = original;
        }, 3000);
      }, 800);
    });
  }

  // Branch list card selection
  const cards = document.querySelectorAll(".branch-card");
  cards.forEach(function (card) {
    card.addEventListener("click", function () {
      cards.forEach(function (c) {
        c.classList.remove("border-2", "border-secondary");
        c.classList.add("border", "border-outline-variant/30");
      });
      card.classList.remove("border", "border-outline-variant/30");
      card.classList.add("border-2", "border-secondary");
    });
  });

  // Ticket form submit feedback
  const ticketForm = document.getElementById("support-ticket-form");
  if (ticketForm) {
    ticketForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const btn = ticketForm.querySelector('button[type="submit"]');
      if (btn) {
        btn.innerHTML =
          '<span class="material-symbols-outlined text-[18px] animate-spin">sync</span><span>Đang gửi...</span>';
        setTimeout(function () {
          btn.innerHTML =
            '<span class="material-symbols-outlined text-[18px]">check</span><span>Gửi thành công!</span>';
          btn.classList.replace("bg-primary", "bg-secondary");
          setTimeout(function () {
            ticketForm.reset();
            btn.innerHTML =
              '<span class="material-symbols-outlined text-[18px]">send</span><span>Gửi Ticket Hỗ Trợ</span>';
            btn.classList.replace("bg-secondary", "bg-primary");
          }, 2500);
        }, 800);
      }
    });
  }
}

function initBookingForm() {
  const form = document.getElementById("booking-form");
  if (!form) return;

  const deviceInput = document.getElementById("device-type");
  const modelInput = document.getElementById("model-name");
  const serialInput = document.getElementById("serial-imei");
  const descriptionInput = document.getElementById("error-description");
  const dateInput = document.getElementById("appointment-date");
  const timeInput = document.getElementById("appointment-time");
  const nameInput = document.getElementById("full-name");
  const phoneInput = document.getElementById("phone");
  const mediaInput = document.getElementById("issue-media");
  const mediaList = document.getElementById("issue-media-list");
  const dateOptions = document.getElementById("date-options");
  const branchInput = form.querySelector('[name="branch_id"]');
  const qrContainer = document.getElementById("booking-qr");
  const qrCodeLabel = document.getElementById("booking-qr-code");

  const setText = (id, value, fallback) => {
    const element = document.getElementById(id);
    if (element) element.textContent = value || fallback;
  };

  const formatDate = (value) => {
    if (!value) return "";
    const date = new Date(`${value}T00:00:00`);
    return date.toLocaleDateString("vi-VN");
  };

  const selectedIssues = () =>
    Array.from(form.querySelectorAll('[name="common_issues[]"]:checked')).map(
      (checkbox) => checkbox.value,
    );

  const refreshIssueStyles = () => {
    form.querySelectorAll(".issue-option").forEach((label) => {
      const checked = label.querySelector("input").checked;
      label.classList.toggle("border-secondary", checked);
      label.classList.toggle("bg-primary-fixed", checked);
      label.classList.toggle("border-surface-container", !checked);
      const text = label.querySelector("span");
      if (text) {
        text.classList.toggle("font-semibold", checked);
        text.classList.toggle("text-primary", checked);
        text.classList.toggle("text-on-surface", !checked);
      }
    });
  };

  const refreshSummary = () => {
    const issues = selectedIssues();
    const description = descriptionInput.value.trim();
    const issueText = [...issues, description].filter(Boolean).join(" | ");
    const branchText =
      branchInput.options[branchInput.selectedIndex]?.text || "";
    const appointmentText =
      dateInput.value && timeInput.value
        ? `${timeInput.value} - ${formatDate(dateInput.value)}`
        : "";

    setText(
      "summary-device",
      [deviceInput.value, modelInput.value.trim()].filter(Boolean).join(" - "),
      "Chưa chọn",
    );
    setText("summary-issue", issueText, "Chưa nhập");
    setText("summary-branch", branchText, "Chưa chọn");
    setText("summary-time", appointmentText, "Chưa chọn");
    setText(
      "summary-customer",
      [nameInput.value.trim(), phoneInput.value.trim()]
        .filter(Boolean)
        .join(" - "),
      "Chưa nhập",
    );
  };

  const refreshQr = () => {
    const payload = {
      device_type: deviceInput.value,
      model_name: modelInput.value.trim(),
      serial_imei: serialInput.value.trim(),
      issues: selectedIssues(),
      error_description: descriptionInput.value.trim(),
      branch: branchInput.options[branchInput.selectedIndex]?.text || "",
      appointment_date: dateInput.value,
      appointment_time: timeInput.value,
      full_name: nameInput.value.trim(),
      phone: phoneInput.value.trim(),
    };
    const qrText = JSON.stringify(payload);
    if (qrCodeLabel)
      qrCodeLabel.textContent =
        qrText.length > 2 ? "QR trực tiếp" : "Chưa có dữ liệu";
    if (qrContainer && window.QRCode) {
      qrContainer.innerHTML = "";
      new QRCode(qrContainer, {
        text: qrText,
        width: 112,
        height: 112,
        colorDark: "#002753",
        colorLight: "#ffffff",
      });
    }
  };

  const refresh = () => {
    refreshIssueStyles();
    refreshSummary();
    refreshQr();
  };

  if (mediaInput && mediaList) {
    mediaInput.addEventListener("change", () => {
      const files = Array.from(mediaInput.files || []);
      if (
        files.length > 5 ||
        files.some((file) => file.size > 50 * 1024 * 1024)
      ) {
        alert("Vui lòng chọn tối đa 5 tệp và mỗi tệp không quá 50MB.");
        mediaInput.value = "";
        mediaList.replaceChildren();
        mediaList.classList.add("hidden");
        return;
      }

      mediaList.replaceChildren(
        ...files.map((file) => {
          const item = document.createElement("span");
          item.className =
            "rounded bg-surface-container px-2 py-1 text-xs text-on-surface-variant";
          item.textContent = file.name;
          return item;
        }),
      );
      mediaList.classList.toggle("hidden", files.length === 0);
    });
  }

  form.querySelectorAll(".device-option").forEach((button) => {
    button.addEventListener("click", () => {
      deviceInput.value = button.dataset.deviceType || "";
      form.querySelectorAll(".device-option").forEach((option) => {
        const selected = option === button;
        option.classList.toggle("border-2", selected);
        option.classList.toggle("border-secondary", selected);
        option.classList.toggle("bg-primary-fixed", selected);
        option.classList.toggle("text-primary", selected);
        option.classList.toggle("border", !selected);
        const check = option.querySelector(".device-check");
        if (check) check.classList.toggle("hidden", !selected);
      });
      refresh();
    });
  });

  form.querySelectorAll('[name="common_issues[]"]').forEach((checkbox) => {
    checkbox.addEventListener("change", refresh);
  });

  const today = new Date();
  dateInput.min = today.toISOString().slice(0, 10);
  const dateFormatter = new Intl.DateTimeFormat("vi-VN", { weekday: "short" });
  for (let offset = 0; offset < 4; offset += 1) {
    const date = new Date(today);
    date.setHours(0, 0, 0, 0);
    date.setDate(today.getDate() + offset);
    const isoDate = date.toISOString().slice(0, 10);
    const button = document.createElement("button");
    button.className =
      "date-option py-2 px-1 rounded-lg border border-surface-container bg-surface-container-low text-center hover:border-secondary transition-all";
    button.dataset.date = isoDate;
    button.type = "button";
    button.innerHTML = `<span class="block text-[11px] text-on-surface-variant">${offset === 0 ? "Hôm nay" : dateFormatter.format(date)}</span><span class="block font-label-md font-bold text-on-surface">${date.getDate()}/${date.getMonth() + 1}</span>`;
    button.addEventListener("click", () => {
      dateInput.value = isoDate;
      dateOptions.querySelectorAll(".date-option").forEach((option) => {
        const selected = option === button;
        option.classList.toggle("border-2", selected);
        option.classList.toggle("border-secondary", selected);
        option.classList.toggle("bg-primary-container", selected);
        option.classList.toggle("text-on-primary", selected);
        option.classList.toggle("border", !selected);
      });
      refresh();
    });
    dateOptions.appendChild(button);
  }

  form.querySelectorAll(".time-option").forEach((button) => {
    button.addEventListener("click", () => {
      timeInput.value = button.dataset.time || "";
      form.querySelectorAll(".time-option").forEach((option) => {
        const selected = option === button;
        option.classList.toggle("border-secondary", selected);
        option.classList.toggle("bg-secondary", selected);
        option.classList.toggle("text-on-secondary", selected);
        option.classList.toggle("font-bold", selected);
        option.classList.toggle("border-surface-container", !selected);
        option.classList.toggle("bg-surface-container-low", !selected);
        option.classList.toggle("text-on-surface", !selected);
      });
      refresh();
    });
  });

  [
    modelInput,
    serialInput,
    descriptionInput,
    dateInput,
    nameInput,
    phoneInput,
    branchInput,
  ].forEach((input) => {
    input.addEventListener("input", refresh);
    input.addEventListener("change", refresh);
  });

  dateOptions.querySelector(".date-option")?.click();
  form.querySelector(".time-option")?.click();
  refresh();
}

document.addEventListener("DOMContentLoaded", function () {
  wireInternalLinks();
  applyAuthenticationPrivacy();
  initAuthenticationControls();
  initWaveBackground();
  initAuthenticationGate();
  initLookupPage();
  initRepairDecisionPage();
  initBranchSupportPage();
  initBookingForm();
});

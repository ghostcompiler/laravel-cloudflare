// Setup Code Copy Buttons for generic pre blocks
document.querySelectorAll("pre:not(.response-body-pre)").forEach((block) => {
  const button = document.createElement("button");
  button.className = "copy-button";
  button.type = "button";
  button.textContent = "Copy";
  button.addEventListener("click", async () => {
    const code = block.querySelector("code")?.innerText ?? "";
    await navigator.clipboard.writeText(code);
    button.textContent = "Copied";
    window.setTimeout(() => {
      button.textContent = "Copy";
    }, 1400);
  });
  block.appendChild(button);
});

// Generate Table of Contents (On This Page)
const sections = [...document.querySelectorAll(".doc-article section[id]")];
const toc = document.querySelector("#toc");

if (toc && sections.length) {
  sections.forEach((section) => {
    const title = section.dataset.title || section.querySelector("h2, h1")?.textContent || section.id;
    const link = document.createElement("a");
    link.href = `#${section.id}`;
    link.textContent = title;
    toc.appendChild(link);
  });
}

// Sidebar & TOC Active Scrolling Highlight
const navLinks = [...document.querySelectorAll(".docs-sidebar a, .on-this-page a")];

if (sections.length && navLinks.length) {
  const observer = new IntersectionObserver((entries) => {
    const active = entries
      .filter((entry) => entry.isIntersecting)
      .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];

    if (!active) return;

    navLinks.forEach((link) => {
      link.classList.toggle("active", link.getAttribute("href") === `#${active.target.id}`);
    });
  }, {
    rootMargin: "-18% 0px -68% 0px",
    threshold: [0.05, 0.2, 0.4]
  });

  sections.forEach((section) => observer.observe(section));
}

// Search Filter Sidebar Group Links
const search = document.querySelector("#docSearch");

if (search) {
  search.addEventListener("input", () => {
    const query = search.value.trim().toLowerCase();
    document.querySelectorAll(".docs-sidebar a").forEach((link) => {
      if (link.classList.contains("close-sidebar-btn")) return;
      link.style.display = !query || link.textContent.toLowerCase().includes(query) ? "" : "none";
    });
  });
}

// Theme Engine (Light / Dark / System Sync)
const themeButtons = document.querySelectorAll(".theme-control-btn");
let currentTheme = localStorage.getItem("docs_theme") || "system";

function applyTheme(theme) {
  const root = document.documentElement;
  
  if (theme === "dark") {
    root.setAttribute("data-theme", "dark");
  } else if (theme === "light") {
    root.removeAttribute("data-theme");
  } else {
    const prefersDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
    if (prefersDark) {
      root.setAttribute("data-theme", "dark");
    } else {
      root.removeAttribute("data-theme");
    }
  }
  
  themeButtons.forEach((btn) => {
    btn.classList.toggle("active", btn.dataset.themeVal === theme);
  });
}

// Initial Theme execution
applyTheme(currentTheme);

themeButtons.forEach((btn) => {
  btn.addEventListener("click", () => {
    currentTheme = btn.dataset.themeVal;
    localStorage.setItem("docs_theme", currentTheme);
    applyTheme(currentTheme);
  });
});

window.matchMedia("(prefers-color-scheme: dark)").addEventListener("change", () => {
  if (currentTheme === "system") {
    applyTheme("system");
  }
});

// Mobile Sidebar Drawer Menu controls
const mobileMenuBtn = document.querySelector("#mobileMenuBtn");
const closeSidebarBtn = document.querySelector("#closeSidebarBtn");
const docsSidebar = document.querySelector("#docsSidebar");
const sidebarBackdrop = document.querySelector("#sidebarBackdrop");

function openSidebarDrawer() {
  if (docsSidebar && sidebarBackdrop) {
    docsSidebar.classList.add("open");
    sidebarBackdrop.classList.add("active");
    document.body.style.overflow = "hidden";
  }
}

function closeSidebarDrawer() {
  if (docsSidebar && sidebarBackdrop) {
    docsSidebar.classList.remove("open");
    sidebarBackdrop.classList.remove("active");
    document.body.style.overflow = "";
  }
}

if (mobileMenuBtn) {
  mobileMenuBtn.addEventListener("click", openSidebarDrawer);
}
if (closeSidebarBtn) {
  closeSidebarBtn.addEventListener("click", closeSidebarDrawer);
}
if (sidebarBackdrop) {
  sidebarBackdrop.addEventListener("click", closeSidebarDrawer);
}

document.querySelectorAll(".docs-sidebar a").forEach((link) => {
  link.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
      closeSidebarDrawer();
    }
  });
});

// Token Configuration persistence
const tokenInput = document.querySelector("#apiTokenInput");
const saveBtn = document.querySelector("#saveTokenBtn");
let apiToken = localStorage.getItem("cloudflare_token") || "";

if (tokenInput && apiToken) {
  tokenInput.value = apiToken;
}

if (saveBtn) {
  saveBtn.addEventListener("click", () => {
    apiToken = tokenInput.value.trim();
    localStorage.setItem("cloudflare_token", apiToken);
    alert("API Token saved locally!");
  });
}

// Update Global limits elements
function updateGlobalLimits(limit, remaining, reset) {
  const gLimit = document.querySelector("#globalLimitVal");
  const gRem = document.querySelector("#globalRemainingVal");
  const gReset = document.querySelector("#globalResetVal");

  if (gLimit && limit) gLimit.textContent = limit;
  if (gRem && remaining) gRem.textContent = remaining;
  if (gReset && reset) gReset.textContent = reset;
}

// Dynamic API Tester Execution Handler
document.querySelectorAll(".tester-box").forEach((tester) => {
  const method = tester.dataset.method;
  const rawPath = tester.dataset.path;
  const runBtn = tester.querySelector(".run-btn");
  const responsePanel = tester.querySelector(".tester-response");
  const statusDot = tester.querySelector(".status-dot");
  const statusLabel = tester.querySelector(".status-label");
  const latencyLabel = tester.querySelector(".response-latency");
  
  const limitVal = tester.querySelector(".limit-val");
  const remainingVal = tester.querySelector(".remaining-val");
  const resetVal = tester.querySelector(".reset-val");
  
  const codeOutput = tester.querySelector(".response-code");
  const copyResponseBtn = tester.querySelector(".copy-response-btn");

  if (!runBtn) return;

  runBtn.addEventListener("click", async () => {
    if (!apiToken) {
      alert("Please enter and save your Cloudflare API Token in the sidebar authentication widget first!");
      if (tokenInput) tokenInput.focus();
      return;
    }

    let path = rawPath;
    let queryParams = [];
    let missingRequired = false;

    tester.querySelectorAll(".param-input").forEach((input) => {
      const name = input.dataset.paramName;
      const val = input.value.trim();
      const required = input.required;

      if (required && !val) {
        missingRequired = true;
        input.classList.add("input-error");
        input.focus();
      } else {
        input.classList.remove("input-error");
      }

      if (val) {
        if (path.includes(`{${name}}`)) {
          path = path.replace(`{${name}}`, encodeURIComponent(val));
        } else {
          queryParams.push(`${name}=${encodeURIComponent(val)}`);
        }
      }
    });

    if (missingRequired) {
      alert("Please fill out all required parameters.");
      return;
    }

    const queryString = queryParams.length > 0 ? `?${queryParams.join("&")}` : "";
    const url = `https://api.cloudflare.com/client/v4${path}${queryString}`;

    let fetchOptions = {
      method: method,
      headers: {
        "Authorization": `Bearer ${apiToken}`,
        "Accept": "application/json",
        "Content-Type": "application/json"
      }
    };

    // Prepare Request Body if fields exist (e.g. POST/PUT/PATCH)
    const bodyField = tester.querySelector(".body-input");
    if (bodyField && (method === "POST" || method === "PUT" || method === "PATCH")) {
      const bodyVal = bodyField.value.trim();
      if (bodyVal) {
        try {
          fetchOptions.body = JSON.stringify(JSON.parse(bodyVal));
        } catch (e) {
          alert("Invalid JSON format in request body field.");
          bodyField.focus();
          return;
        }
      }
    }

    if (responsePanel) responsePanel.style.display = "block";
    if (statusDot) {
      statusDot.className = "status-dot";
      statusDot.style.background = "";
    }
    if (statusLabel) statusLabel.textContent = "Loading...";
    if (latencyLabel) latencyLabel.textContent = "";
    if (codeOutput) codeOutput.textContent = "Fetching request...";

    const startTime = performance.now();

    try {
      const res = await fetch(url, fetchOptions);
      const endTime = performance.now();
      const latency = Math.round(endTime - startTime);
      if (latencyLabel) latencyLabel.textContent = `${latency}ms`;

      if (statusDot && statusLabel) {
        statusLabel.textContent = `${res.status} ${res.statusText}`;
        if (res.ok) {
          statusDot.classList.add("success");
        } else {
          statusDot.classList.add("error");
        }
      }

      // Parse headers
      const limit = res.headers.get("X-RateLimit-Limit") || res.headers.get("RateLimit-Limit") || "-";
      const remaining = res.headers.get("X-RateLimit-Remaining") || res.headers.get("RateLimit-Remaining") || "-";
      const reset = res.headers.get("X-RateLimit-Reset") || res.headers.get("RateLimit-Reset") || "-";

      if (limitVal) limitVal.textContent = limit;
      if (remainingVal) remainingVal.textContent = remaining;
      if (resetVal) resetVal.textContent = reset;

      updateGlobalLimits(limit, remaining, reset);

      const data = await res.json();
      if (codeOutput) {
        codeOutput.textContent = JSON.stringify(data, null, 2);
      }
    } catch (err) {
      const endTime = performance.now();
      const latency = Math.round(endTime - startTime);
      if (latencyLabel) latencyLabel.textContent = `${latency}ms`;

      if (statusDot && statusLabel) {
        statusLabel.textContent = "Network Error";
        statusDot.classList.add("error");
      }
      if (codeOutput) {
        codeOutput.textContent = `Fetch Failed: ${err.message}`;
      }
    }
  });

  if (copyResponseBtn && codeOutput) {
    copyResponseBtn.addEventListener("click", async () => {
      await navigator.clipboard.writeText(codeOutput.textContent);
      copyResponseBtn.textContent = "Copied";
      window.setTimeout(() => {
        copyResponseBtn.textContent = "Copy";
      }, 1400);
    });
  }
});

const setHtmlTheme = (theme) => {
  const html = document.querySelector("html");

  html.setAttribute("data-bs-theme", theme);
  localStorage.setItem("theme", theme);
};

export { setHtmlTheme };

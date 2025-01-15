import { useContext } from "react";
import { ThemeContext } from "../context/theme";
import Head from "next/head";
import { setHtmlTheme } from "../utilities/helpers";

const ToggleTheme = () => {
  const [theme, setTheme] = useContext(ThemeContext);
  const toggledTheme = theme === "light" ? "dark" : "light";

  return (
    <div
      onClick={() => {
        setTheme(toggledTheme);
        setHtmlTheme(toggledTheme);
      }}
    >
      <span style={{ fontSize: "24px" }}>
        {theme === "light" ? "🌙" : "☀️"}
      </span>
    </div>
  );
};

export default ToggleTheme;

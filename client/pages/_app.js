import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-icons/font/bootstrap-icons.css";
import { Providers } from "../context/providers";
import { useEffect } from "react";
import { setHtmlTheme } from "../utilities/helpers";
import TopNav from "../components/TopNav";

function App({ Component, pageProps }) {
  useEffect(() => {
    const theme = localStorage.getItem("theme");

    if (theme) {
      setHtmlTheme(theme);
    } else {
      setHtmlTheme("light");
    }
  }, []);

  return (
    <Providers>
      <TopNav />
      <Component {...pageProps} />
    </Providers>
  );
}

export default App;

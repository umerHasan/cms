import Dropdown from "./Dropdown";
import ToggleTheme from "./ToggleTheme";
import Link from "next/link";

const TopNav = () => {
  const items = [
    { icon: "bi bi-cloud", text: "CMS", href: "/cms" },
    { icon: "bi bi-card-text", text: "Posts", href: "/posts" },
    { icon: "bi bi-envelope-open", text: "Contact", href: "/contact" },
  ];

  return (
    <nav className="navbar navbar-expand-lg bg-body-tertiary">
      <div className="container-fluid">
        <button
          className="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span className="navbar-toggler-icon"></span>
        </button>

        <div className="collapse navbar-collapse" id="navbarSupportedContent">
          <ul className="navbar-nav nav-underline me-auto mb-2 mb-lg-0">
            {items.map((item, key) => (
              <li className="nav-item" key={key}>
                <Link className="nav-link" href={item.href}>
                  <span className={`${item.icon} mx-1`}></span>
                  {item.text}
                </Link>
              </li>
            ))}
          </ul>
          <ToggleTheme />
        </div>
      </div>
    </nav>
  );
};

export default TopNav;

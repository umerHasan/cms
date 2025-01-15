import { useEffect, useRef, useState } from "react";

const Dropdown = ({
  buttonText = "Dropdown",
  items = [],
  buttonClassName = "btn btn-primary",
  dropdownAlignment = "start", // 'start' or 'end'
}) => {
  const [isOpen, setIsOpen] = useState(false);
  const dropdownRef = useRef(null);

  const toggleDropdown = () => {
    setIsOpen(!isOpen);
  };

  // Handle click outside to close dropdown
  useEffect(() => {
    const handleClickOutside = (event) => {
      if (dropdownRef.current && !dropdownRef.current.contains(event.target)) {
        setIsOpen(false);
      }
    };

    document.addEventListener("mousedown", handleClickOutside);
    return () => {
      document.removeEventListener("mousedown", handleClickOutside);
    };
  }, []);

  return (
    <div className="dropdown" ref={dropdownRef}>
      <button
        className={`${buttonClassName} dropdown-toggle`}
        type="button"
        onClick={toggleDropdown}
        aria-expanded={isOpen}
      >
        {buttonText}
      </button>
      <ul
        className={`dropdown-menu dropdown-menu-${dropdownAlignment} ${
          isOpen ? "show" : ""
        }`}
        style={{
          margin: 0,
          transition: "transform .2s ease-out, opacity .2s ease-out",
          transform: isOpen ? "translate(0, 0)" : "translate(0, -10px)",
          opacity: isOpen ? 1 : 0,
          display: isOpen ? "block" : "none",
        }}
      >
        {items.map((item, index) => (
          <li key={index}>
            <a
              className="dropdown-item"
              href={item.href || "#"}
              onClick={(e) => {
                if (item.onClick) {
                  e.preventDefault();
                  item.onClick();
                  setIsOpen(false);
                }
              }}
            >
              {item.label}
            </a>
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Dropdown;

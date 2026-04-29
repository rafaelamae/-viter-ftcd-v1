import React from "react";
import { FaChevronDown } from "react-icons/fa";
import { NavLink, useLocation } from "react-router-dom";

const NavigationAccordions = ({ subNavList = [], item }) => {
  const { pathname } = useLocation();
  const hasActiveSubmenu = subNavList.some((subItem) => pathname === subItem.path);
  const [isOpen, setIsOpen] = React.useState(hasActiveSubmenu);

  React.useEffect(() => {
    if (hasActiveSubmenu) {
      setIsOpen(true);
    }
  }, [hasActiveSubmenu]);

  return (
    <>
      <button
        className={`nav-link w-full flex items-center justify-between gap-2 ${
          hasActiveSubmenu ? "nav-link-active" : ""
        }`}
        onClick={() => setIsOpen(!isOpen)}
      >
        <div className="flex items-center gap-2">
          {item.icon}
          {item.label}
        </div>
        <FaChevronDown
          className={`transition-transform duration-200 ${isOpen ? "rotate-180" : ""}`}
        />
      </button>

      {isOpen && (
        <ul className="self-start w-full pt-1 pb-2">
          {subNavList.map((item, key) => {
            return (
              <li key={key} className="w-full">
                <NavLink
                  to={item.path}
                  className={({ isActive }) =>
                    `nav-sublink block w-full ${isActive ? "nav-sublink-active" : ""}`
                  }
                >
                  {item.label}
                </NavLink>
              </li>
            );
          })}
        </ul>
      )}
    </>
  );
};

export default NavigationAccordions;

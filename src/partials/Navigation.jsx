import React from "react";
import { StoreContext } from "../store/StoreContext";
import { NavLink } from "react-router-dom";
import NavigationAccordions from "./NavigationAccordions";

const Navigation = ({ navigationList = [], menu = "", submenu = "" }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  const isMobileOrTablet = window.matchMedia("(max-width:1027px)").matches;
  const link = "/developer";
  const scrollRef = React.useRef(null);
  const handleShowNavigation = () => {};
  const handleScroll = () => {};

  return (
    <>
      <div className="print:hidden">
        <nav
          className={`${
            store.isShow ? "translate-x-0" : ""
          } h-dvh duration-200 ease-in fixed z-40 overflow-y-auto w-[14rem] print:hidden py-3 pt-[76px]`}
          ref={scrollRef}
          onScroll={(e) => handleScroll(e)}
        >
          <div className="text-sm text-white flex flex-col justify-between h-full">
            <ul>
              {navigationList.map((item, key) => {
                return (
                  <li
                    key={key}
                    className={`h-fit flex items-center gap-2 ${item.subNavList && "flex-col gap-0.5!"}`}
                  >
                    {item.subNavList ? (
                      <NavigationAccordions
                        subNavList={item.subNavList}
                        item={item}
                      />
                    ) : (
                      <NavLink
                        to={item.path}
                        className={({ isActive }) =>
                          `nav-link w-full ${isActive ? "nav-link-active" : ""}`
                        }
                      >
                        <div className="flex items-center gap-2">
                          {item.icon} {item.label}
                        </div>
                      </NavLink>
                    )}
                  </li>
                );
              })}
            </ul>
          </div>
        </nav>
        {/* <span
          className={`${
            store.isShow ? "" : "-translate-x-full"
          } fixed z-30 w-screen h-screen bg-dark/50 ${
            isMobileOrTablet ? "" : "lg:hidden"
          }`}
          onClick={handleShowNavigation}
          onTouchMove={handleShowNavigation}
        ></span> */}
      </div>
    </>
  );
};

export default Navigation;

import React from "react";
import { FaArrowLeft } from "react-icons/fa";
import { BiLeftIndent } from "react-icons/bi";
import { Link, useLocation, useNavigate } from "react-router-dom";
import { setIsSearch } from "../store/StoreAction";
import { StoreContext } from "../store/StoreContext";
import { devNavUrl, urlDeveloper } from "../functions/functions-general";

const BreadCrumbs = ({ param = "", parentPath = "" }) => {
  const { dispatch } = React.useContext(StoreContext);
  const location = useLocation();
  const navigate = useNavigate();
  const link = `${devNavUrl}/${urlDeveloper}`;

  const handleClick = () => {
    sessionStorage.removeItem("resultItem");
    sessionStorage.removeItem("payrunListReport");
    sessionStorage.removeItem("benefitsList");
    sessionStorage.removeItem("loanList");
    sessionStorage.removeItem("salaryHistoryList");
    dispatch(setIsSearch(false));
  };

  const crumbs = location.pathname
    .replace(`${link}`, "")
    .split("/")
    .filter((crumb) => crumb !== "")
    .map((crumb, index, arr) => {
      const href = `${link}/${arr.slice(0, index + 1).join("/")}`;
      const label = (index === arr.length - 1 && param ? param : crumb)
        .replaceAll("-ftw", " ")
        .replaceAll("-ue", " ")
        .replaceAll("ftw-", " ")
        .replaceAll("-", " ")
        .replaceAll("daily time record entries", "time entries");
      const isLast = index === arr.length - 1;

      return (
        <li
          className="flex items-center text-sm"
          key={`${crumb}-${index}`}
          onClick={!isLast ? handleClick : undefined}
        >
          {isLast ? (
            <span className="capitalize text-dark">{label}</span>
          ) : (
            <Link
              to={href}
              className="capitalize text-primary hover:text-dark transition-colors"
            >
              {label}
            </Link>
          )}
          {!isLast && <span className="mx-3 text-gray-400">{">"}</span>}
        </li>
      );
    });

  return (
    <div className="flex items-center gap-6">
      {parentPath && (
        <button
          type="button"
          className="print:hidden flex items-center text-dark hover:text-primary transition-colors"
          onClick={() => navigate(parentPath)}
          title="Users"
        >
          <BiLeftIndent className="h-5 w-5" />
        </button>
      )}

      <button
        type="button"
        className="print:hidden flex items-center text-dark hover:text-primary transition-colors"
        onClick={() => navigate(-1)}
        title="Back"
      >
        <FaArrowLeft className="h-5 w-5" />
      </button>

      <ul className="flex items-center text-xs">{crumbs}</ul>
    </div>
  );
};

export default BreadCrumbs;
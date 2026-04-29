import React from "react";
import Layout from "../../Layout";
import { Link } from "react-router-dom";
import { devNavUrl, urlDeveloper } from "../../../../functions/functions-general";
import BreadCrumbs from "../../../../partials/BreadCrumbs";
import { FaChevronRight } from "react-icons/fa";
import { FaRegUserCircle } from "react-icons/fa";
import { BiLeftIndent } from "react-icons/bi";

const Users = () => {
  const menuItems = [
    {
      label: "System user",
      path: `${devNavUrl}/${urlDeveloper}/settings/users/system`,
    },
    {
      label: "Other user",
      path: `${devNavUrl}/${urlDeveloper}/settings/users/other`,
    },
    {
      label: "Roles",
      path: `${devNavUrl}/${urlDeveloper}/settings/users/roles`,
    },
  ];

  return (
    <Layout menu="settings">
      <div className="flex items-center gap-2">
        <BiLeftIndent className="size-5 text-dark" />
        <BreadCrumbs />
      </div>

      <h1 className="text-lg mb-6 mt-5">Users</h1>

      <div className="divide-y divide-gray-200 border-t border-b border-gray-200">
        {menuItems.map((item, key) => (
          <Link
            key={key}
            to={item.path}
            className="flex items-center justify-between py-4 px-1 hover:bg-gray-50 transition-colors"
          >
            <div className="flex items-center gap-3">
              <FaRegUserCircle className="text-gray-500 text-xl" />
              <span className="text-sm font-medium text-dark">{item.label}</span>
            </div>
            <FaChevronRight className="text-gray-400 text-xs" />
          </Link>
        ))}
      </div>
    </Layout>
  );
};

export default Users;

import {
  FaCogs,
  FaUser,
  FaUsers,
  FaList,
  FaChild,
  FaTag,
  FaBell,
  FaTools,
  FaIdBadge,
} from "react-icons/fa";
import { MdContactMail } from "react-icons/md";
import { FaHandHoldingHeart } from "react-icons/fa6";
import { devNavUrl, urlDeveloper } from "../../functions/functions-general";

export const navList = [
  {
    label: "DONOR LIST",
    icon: <FaHandHoldingHeart />,
    menu: "donors",
    path: `${devNavUrl}/${urlDeveloper}/donors`,
    submenu: "",
  },
  {
    label: "CHILDREN LIST",
    icon: <FaUsers />,
    menu: "children",
    path: `${devNavUrl}/${urlDeveloper}/children`,
    submenu: "",
  },
  {
    label: "REPORTS",
    icon: <FaList />,
    menu: "reports",
    submenu: "",
    subNavList: [
      {
        label: "Donations",
        path: `${devNavUrl}/${urlDeveloper}/reports/donations`,
      },
      {
        label: "Contact Us",
        path: `${devNavUrl}/${urlDeveloper}/reports/contact-us`,
      },
      {
        label: "FAQ",
        path: `${devNavUrl}/${urlDeveloper}/reports/faq`,
      },
    ],
  },
  {
    label: "SETTINGS",
    icon: <FaCogs />,
    menu: "settings",
    submenu: "",
    subNavList: [
      {
        label: "Users",
        path: `${devNavUrl}/${urlDeveloper}/settings/users`,
      },
      {
        label: "Category",
        path: `${devNavUrl}/${urlDeveloper}/settings/category`,
      },
      {
        label: "Designation",
        path: `${devNavUrl}/${urlDeveloper}/settings/designation`,
      },
      {
        label: "Notification",
        path: `${devNavUrl}/${urlDeveloper}/settings/notification`,
      },
      {
        label: "Maintenance",
        path: `${devNavUrl}/${urlDeveloper}/settings/maintenance`,
      },
    ],
  },
];

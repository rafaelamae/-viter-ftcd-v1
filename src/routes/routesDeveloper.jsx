import { devNavUrl, urlDeveloper } from "../functions/functions-general";
import Donors from "../pages/developer/donors/Donors";
import Children from "../pages/developer/children/Children";
import Users from "../pages/developer/settings/users/Users";
import SystemUsers from "../pages/developer/settings/users/SystemUsers";
import OtherUsers from "../pages/developer/settings/users/OtherUsers";
import Roles from "../pages/developer/settings/users/Roles";
import Category from "../pages/developer/settings/category/Category";
import Designation from "../pages/developer/settings/designation/Designation";
import Notification from "../pages/developer/settings/notification/Notification";

export const routesDeveloper = [
  // Default — redirect to donors
  {
    path: `${devNavUrl}/${urlDeveloper}/`,
    element: <Donors />,
  },
  // Donor List
  {
    path: `${devNavUrl}/${urlDeveloper}/donors`,
    element: <Donors />,
  },
  // Children List
  {
    path: `${devNavUrl}/${urlDeveloper}/children`,
    element: <Children />,
  },
  // Settings - Users
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/users`,
    element: <Users />,
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/users/system`,
    element: <SystemUsers />,
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/users/other`,
    element: <OtherUsers />,
  },
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/users/roles`,
    element: <Roles />,
  },
  // Settings - Category
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/category`,
    element: <Category />,
  },
  // Settings - Designation
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/designation`,
    element: <Designation />,
  },
  // Settings - Notification
  {
    path: `${devNavUrl}/${urlDeveloper}/settings/notification`,
    element: <Notification />,
  },
];

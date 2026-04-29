import React from "react";
import Layout from "../../Layout";
import { StoreContext } from "../../../../store/StoreContext";
import { setIsAdd } from "../../../../store/StoreAction";
import { FaPlus } from "react-icons/fa";
import { devNavUrl, urlDeveloper } from "../../../../functions/functions-general";
import OtherUsersList from "./OtherUsersList";
import ModalAddOtherUsers from "./ModalAddOtherUsers";
import BreadCrumbs from "../../../../partials/BreadCrumbs";

const OtherUsers = () => {
  const { store, dispatch } = React.useContext(StoreContext);
  const [itemEdit, setItemEdit] = React.useState(null);

  const handleAdd = () => {
    dispatch(setIsAdd(true));
    setItemEdit(null);
  };

  return (
    <>
      <Layout menu="settings" submenu="users">
        <div className="flex items-center justify-between gap-4 w-full mb-4">
          <BreadCrumbs
            param="Other user"
            parentPath={`${devNavUrl}/${urlDeveloper}/settings/users`}
          />
          <button
            type="button"
            className="flex items-center gap-1 text-primary font-medium hover:underline"
            onClick={handleAdd}
          >
            <FaPlus />
            Add
          </button>
        </div>

        <h1 className="text-lg mb-4">Other user</h1>

        <div>
          <OtherUsersList itemEdit={itemEdit} setItemEdit={setItemEdit} />
        </div>
      </Layout>

      {store.isAdd && <ModalAddOtherUsers itemEdit={itemEdit} />}
    </>
  );
};

export default OtherUsers;
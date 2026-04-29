import React from "react";
import Layout from "../Layout";
import { StoreContext } from "../../../store/StoreContext";
import { setIsAdd } from "../../../store/StoreAction";
import { FaPlus } from "react-icons/fa";
import { BiLeftIndent } from "react-icons/bi";
import ChildrenList from "./ChildrenList";
import ModalAddChildren from "./ModalAddChildren";

const Children = () => {
  const { store, dispatch } = React.useContext(StoreContext);
  const [itemEdit, setItemEdit] = React.useState(null);

  const handleAdd = () => {
    dispatch(setIsAdd(true));
    setItemEdit(null);
  };

  return (
    <>
      <Layout menu="children">
        {/* PAGE HEADER */}
        <div className="flex items-center justify-between w-full">
          <div className="flex items-center gap-2">
            <BiLeftIndent className="size-5" />
            <h1 className="text-lg">Children List</h1>
          </div>

          <div>
            <button
              type="button"
              className="flex items-center gap-1 hover:underline"
              onClick={handleAdd}
            >
              <FaPlus className="text-primary" />
              Add
            </button>
          </div>
        </div>

        {/* PAGE CONTENT */}
        <div>
          <ChildrenList itemEdit={itemEdit} setItemEdit={setItemEdit} />
        </div>
      </Layout>

      {store.isAdd && <ModalAddChildren itemEdit={itemEdit} />}
    </>
  );
};

export default Children;
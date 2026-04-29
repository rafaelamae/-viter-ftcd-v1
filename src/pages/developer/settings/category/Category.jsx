import React from "react";
import Layout from "../../Layout";
import { StoreContext } from "../../../../store/StoreContext";
import { setIsAdd } from "../../../../store/StoreAction";
import { FaPlus } from "react-icons/fa";
import { devNavUrl, urlDeveloper } from "../../../../functions/functions-general";
import CategoryList from "./CategoryList";
import ModalAddCategory from "./ModalAddCategory";
import BreadCrumbs from "../../../../partials/BreadCrumbs";

const Category = () => {
  const { store, dispatch } = React.useContext(StoreContext);
  const [itemEdit, setItemEdit] = React.useState(null);

  const handleAdd = () => {
    dispatch(setIsAdd(true));
    setItemEdit(null);
  };

  return (
    <>
      <Layout menu="settings">
        <div className="flex items-center justify-between gap-4 w-full mb-4">
          <BreadCrumbs
            param="Category"
            parentPath={`${devNavUrl}/${urlDeveloper}/settings`}
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

        <h1 className="text-lg mb-4">Category</h1>

        <div>
          <CategoryList itemEdit={itemEdit} setItemEdit={setItemEdit} />
        </div>
      </Layout>

      {store.isAdd && <ModalAddCategory itemEdit={itemEdit} />}
    </>
  );
};

export default Category;
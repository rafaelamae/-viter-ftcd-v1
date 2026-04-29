import React from "react";
import Layout from "../Layout";
import { StoreContext } from "../../../store/StoreContext";
import { setIsAdd } from "../../../store/StoreAction";
import { FaBars, FaIndent, FaList, FaPlus } from "react-icons/fa";
import ButtonSpinner from "../../../partials/spinners/ButtonSpinner";
import DonorsList from "./DonorsList";
import ModalAddDonors from "./ModalAddDonors";
import { BiLeftIndent } from "react-icons/bi";

const Donors = () => {
  const { store, dispatch } = React.useContext(StoreContext);
  const [itemEdit, setItemEdit] = React.useState(null);

  const handleAdd = () => {
    dispatch(setIsAdd(true));
    setItemEdit(null);
  };

  return (
    <>
      <Layout menu="donors">
        {/* PAGE HEADER */}
        <div className="flex items-center justify-between w-full">
          <div className="flex items-center gap-2">
              <BiLeftIndent className="size-5" /> 
            <h1 className="text-lg">Donor List</h1>
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
          <DonorsList itemEdit={itemEdit} setItemEdit={setItemEdit} />
        </div>
      </Layout>

      {store.isAdd && <ModalAddDonors itemEdit={itemEdit} />}
    </>
  );
};

export default Donors;

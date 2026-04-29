import React from "react";
import { StoreContext } from "../../../store/StoreContext";
import * as Yup from "yup";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { queryData } from "../../../functions/custom-hooks/queryData";
import { apiVersion } from "../../../functions/functions-general";
import {
  setIsAdd,
  setSuccess,
  setError,
  setMessage,
} from "../../../store/StoreAction";
import ModalWrapperSide from "../../../partials/modals/ModalWrapperSide";
import { FaTimes } from "react-icons/fa";
import { Formik, Form, Field } from "formik";
import ButtonSpinner from "../../../partials/spinners/ButtonSpinner";
import { InputText } from "../../../components/form-input/FormInputs";
import MessageError from "../../../partials/MessageError";

const ModalAddDonors = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  const queryClient = useQueryClient();

  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/donors/donors.php?id=${itemEdit.donor_aid}`
          : `${apiVersion}/controllers/developers/donors/donors.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["donors"] });
      if (data.success) {
        dispatch(setSuccess(true));
        dispatch(setMessage(`Successfully ${itemEdit ? "updated" : "added"}`));
        dispatch(setIsAdd(false));
      }
      if (data.success === false) {
        dispatch(setError(true));
        dispatch(setMessage(data.error));
      }
    },
  });

  const initVal = {
    donor_is_active: itemEdit ? itemEdit.donor_is_active : 0,
    donor_full_name: itemEdit ? itemEdit.donor_full_name : "",
    donor_email: itemEdit ? itemEdit.donor_email : "",
    donor_contact: itemEdit ? itemEdit.donor_contact : "",
    donor_address: itemEdit ? itemEdit.donor_address : "",
    donor_city: itemEdit ? itemEdit.donor_city : "",
    donor_state: itemEdit ? itemEdit.donor_state : "",
    donor_country: itemEdit ? itemEdit.donor_country : "",
    donor_zip: itemEdit ? itemEdit.donor_zip : "",
    donor_email_old: itemEdit ? itemEdit.donor_email : "",
  };

  const yupSchema = Yup.object({
    donor_full_name: Yup.string().trim().required("Required"),
    donor_email: Yup.string()
      .trim()
      .email("Invalid email")
      .required("Required"),
  });

  const handleClose = () => {
    dispatch(setIsAdd(false));
  };

  React.useEffect(() => {
    dispatch(setError(false));
  }, []);

  return (
    <>
      <ModalWrapperSide
        handleClose={handleClose}
        className="transition-all ease-in-out transform duration-200"
      >
        {/* Modal header */}
        <div className="modal-header relative mb-4">
          <h3 className="text-dark text-sm">
            {itemEdit ? "Update" : "Add"} Donor
          </h3>
          <button
            type="button"
            className="absolute top-0 right-4"
            onClick={handleClose}
          >
            <FaTimes />
          </button>
        </div>

        {/* Modal body */}
        <div className="modal-body">
          <Formik
            initialValues={initVal}
            validationSchema={yupSchema}
            onSubmit={async (values) => {
              dispatch(setError(false));
              mutation.mutate(values);
            }}
          >
            {(props) => (
              <Form className="h-full">
                <div className="modal-form-container">
                  <div className="modal-container">
                    {/* Active checkbox — matches screenshot top checkbox */}
                    <div className="flex items-center gap-2 mb-6">
                      <Field
                        type="checkbox"
                        name="donor_is_active"
                        id="donor_is_active"
                        className="!h-4 !w-4 accent-primary"
                        checked={props.values.donor_is_active == 1}
                        onChange={(e) =>
                          props.setFieldValue(
                            "donor_is_active",
                            e.target.checked ? 1 : 0,
                          )
                        }
                        disabled={mutation.isPending}
                      />
                      <label
                        htmlFor="donor_is_active"
                        className="!relative !transform-none !translate-y-0 !translate-x-0 !left-0 !top-0 !text-primary cursor-pointer"
                      >
                        Active
                      </label>
                    </div>

                    {/* Full Name */}
                    <div className="relative mb-6">
                      <InputText
                        label="Full Name"
                        name="donor_full_name"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Email */}
                    <div className="relative mb-6">
                      <InputText
                        label="Email"
                        name="donor_email"
                        type="email"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Contact Number */}
                    <div className="relative mb-6">
                      <InputText
                        label="Contact Number"
                        name="donor_contact"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Address */}
                    <div className="relative mb-6">
                      <label
                        htmlFor="donor_address"
                        className="text-xs text-primary transform -translate-y-6 -translate-x-1 absolute left-3 top-4 px-1 z-10 isolate"
                      >
                        Address
                        <span className="content-[''] w-[97%] h-[2.5px] absolute left-px top-[7.2px] bg-white -z-10"></span>
                      </label>
                      <Field
                        as="textarea"
                        id="donor_address"
                        name="donor_address"
                        disabled={mutation.isPending}
                        className="block border border-solid border-gray-300 p-2 rounded-lg w-full h-28 bg-transparent outline-none focus:border-primary pt-4"
                      />
                    </div>

                    {/* City */}
                    <div className="relative mb-6">
                      <InputText
                        label="City"
                        name="donor_city"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* State/Province */}
                    <div className="relative mb-6">
                      <InputText
                        label="State/Province"
                        name="donor_state"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Country */}
                    <div className="relative mb-6">
                      <InputText
                        label="Country"
                        name="donor_country"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Zip */}
                    <div className="relative mb-6">
                      <InputText
                        label="Zip"
                        name="donor_zip"
                        type="text"
                        disabled={mutation.isPending}
                      />
                      {store.error && <MessageError />}
                    </div>
                  </div>

                  {/* Action buttons */}
                  <div className="modal-action">
                    <button
                      type="submit"
                      disabled={mutation.isPending || !props.dirty}
                      className="btn-modal-submit"
                    >
                      {mutation.isPending ? (
                        <ButtonSpinner />
                      ) : itemEdit ? (
                        "Save"
                      ) : (
                        "Add"
                      )}
                    </button>
                    <button
                      type="reset"
                      className="btn-modal-cancel"
                      onClick={handleClose}
                      disabled={mutation.isPending}
                    >
                      Cancel
                    </button>
                  </div>
                </div>
              </Form>
            )}
          </Formik>
        </div>
      </ModalWrapperSide>
    </>
  );
};

export default ModalAddDonors;

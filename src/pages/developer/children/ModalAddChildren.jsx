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

const ModalAddChildren = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  const queryClient = useQueryClient();

  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/children/children.php?id=${itemEdit.children_aid}`
          : `${apiVersion}/controllers/developers/children/children.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["children"] });
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
    children_full_name:      itemEdit ? itemEdit.children_full_name      : "",
    children_birth_date:     itemEdit ? itemEdit.children_birth_date     : "",
    children_my_story:       itemEdit ? itemEdit.children_my_story       : "",
    children_donation_limit: itemEdit ? itemEdit.children_donation_limit : "",
    children_is_resident:    itemEdit ? itemEdit.children_is_resident    : 0,
  };

  const yupSchema = Yup.object({
    children_full_name: Yup.string().trim().required("Required"),
    children_birth_date: Yup.string().trim().required("Required"),
    children_donation_limit: Yup.number()
      .typeError("Must be a number")
      .min(0, "Must be 0 or greater")
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
            {itemEdit ? "Update" : "Add"} Children
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
                    {/* Full Name */}
                    <div className="relative mb-6">
                      <InputText
                        label="Full Name"
                        name="children_full_name"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Birth Date */}
                    <div className="relative mb-6">
                      <InputText
                        label="Birth Date"
                        name="children_birth_date"
                        type="date"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* My Story — textarea */}
                    <div className="relative mb-6">
                      <label
                        htmlFor="children_my_story"
                        className="text-xs text-primary transform -translate-y-6 -translate-x-1 absolute left-3 top-4 px-1 z-10 isolate"
                      >
                        My Story
                        <span className="content-[''] w-[97%] h-[2.5px] absolute left-px top-[7.2px] bg-white -z-10"></span>
                      </label>
                      <Field
                        as="textarea"
                        id="children_my_story"
                        name="children_my_story"
                        disabled={mutation.isPending}
                        className="block border border-solid border-gray-300 p-2 rounded-lg w-full h-36 bg-transparent outline-none focus:border-primary pt-4"
                      />
                    </div>

                    {/* Donation Amount Limit */}
                    <div className="relative mb-6">
                      <InputText
                        label="Donation Amount Limit"
                        name="children_donation_limit"
                        type="number"
                        step="0.01"
                        min="0"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Mark Check If Resident — checkbox at bottom */}
                    <div className="flex items-center gap-2 mb-6">
                      <Field
                        type="checkbox"
                        name="children_is_resident"
                        id="children_is_resident"
                        className="!h-4 !w-4 accent-primary"
                        checked={props.values.children_is_resident == 1}
                        onChange={(e) =>
                          props.setFieldValue(
                            "children_is_resident",
                            e.target.checked ? 1 : 0,
                          )
                        }
                        disabled={mutation.isPending}
                      />
                      <label
                        htmlFor="children_is_resident"
                        className="!relative !transform-none !translate-y-0 !translate-x-0 !left-0 !top-0 !text-primary cursor-pointer"
                      >
                        Mark Check If Resident
                      </label>
                    </div>

                    {store.error && <MessageError />}
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

export default ModalAddChildren;
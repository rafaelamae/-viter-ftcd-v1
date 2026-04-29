import React from "react";
import { StoreContext } from "../../../../store/StoreContext";
import * as Yup from "yup";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { queryData } from "../../../../functions/custom-hooks/queryData";
import { apiVersion } from "../../../../functions/functions-general";
import {
  setIsAdd,
  setSuccess,
  setError,
  setMessage,
} from "../../../../store/StoreAction";
import ModalWrapperSide from "../../../../partials/modals/ModalWrapperSide";
import { FaTimes } from "react-icons/fa";
import { Formik, Form, Field } from "formik";
import ButtonSpinner from "../../../../partials/spinners/ButtonSpinner";
import { InputText } from "../../../../components/form-input/FormInputs";

const purposeOptions = [
  "For New Donor",
  "For Donation Receipt",
  "For Contact Us",
  "For FAQ",
];

const ModalAddNotification = ({ itemEdit }) => {
  const { dispatch } = React.useContext(StoreContext);
  const queryClient = useQueryClient();

  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/settings/notification/notification.php?id=${itemEdit.noti_aid}`
          : `${apiVersion}/controllers/developers/settings/notification/notification.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["notification"] });
      queryClient.invalidateQueries({ queryKey: ["notification-active"] });
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
    noti_is_active: itemEdit ? itemEdit.noti_is_active : 1,
    noti_name: itemEdit ? itemEdit.noti_name : "",
    noti_email: itemEdit ? itemEdit.noti_email : "",
    noti_phone: itemEdit ? itemEdit.noti_phone : "",
    noti_purpose: itemEdit ? itemEdit.noti_purpose : "",
  };

  const yupSchema = Yup.object({
    noti_name: Yup.string().trim().required("Required"),
    noti_email: Yup.string().trim().email("Invalid email").required("Required"),
    noti_purpose: Yup.string()
      .oneOf(purposeOptions, "Invalid purpose")
      .required("Required"),
  });

  const handleClose = () => {
    dispatch(setIsAdd(false));
  };

  React.useEffect(() => {
    dispatch(setError(false));
  }, [dispatch]);

  return (
    <>
      <ModalWrapperSide
        handleClose={handleClose}
        className="transition-all ease-in-out transform duration-200 !max-w-[25rem] py-12 pl-6"
      >
        <div className="modal-header relative mb-8">
          <h3 className="text-dark text-sm">
            {itemEdit ? "Update" : "Add"} Notification
          </h3>
          <button
            type="button"
            className="absolute -top-1 right-4 text-primary text-lg"
            onClick={handleClose}
          >
            <FaTimes />
          </button>
        </div>

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
                  <div className="relative mb-8">
                    <InputText
                      label="Name"
                      name="noti_name"
                      type="text"
                      disabled={mutation.isPending}
                    />
                  </div>

                  <div className="relative mb-8">
                    <InputText
                      label="Email"
                      name="noti_email"
                      type="email"
                      disabled={mutation.isPending}
                    />
                  </div>

                  <div className="relative mb-8">
                    <InputText
                      label="Phone"
                      name="noti_phone"
                      type="text"
                      required={false}
                      disabled={mutation.isPending}
                    />
                  </div>

                  <div className="relative mb-8">
                    <Field
                      as="select"
                      id="noti_purpose"
                      name="noti_purpose"
                      disabled={mutation.isPending}
                      className="h-[35px] border border-solid border-gray-300 p-2 rounded-lg w-full bg-transparent outline-none focus:border-primary"
                    >
                      <option value=""></option>
                      {purposeOptions.map((option) => (
                        <option value={option} key={option}>
                          {option}
                        </option>
                      ))}
                    </Field>
                    <label htmlFor="noti_purpose">
                      <span className="text-alert">*</span>Purpose
                    </label>
                  </div>
                </div>

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
      </ModalWrapperSide>
    </>
  );
};

export default ModalAddNotification;

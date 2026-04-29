import React from "react";
import { StoreContext } from "../../../../store/StoreContext";
import * as Yup from "yup";
import { useMutation, useQuery, useQueryClient } from "@tanstack/react-query";
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
import MessageError from "../../../../partials/MessageError";
const ModalAddSystemUsers = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  const queryClient = useQueryClient();

  // Fetch roles for dropdown
  const { data: rolesData } = useQuery({
    queryKey: ["roles-active"],
    queryFn: () =>
      queryData(`${apiVersion}/controllers/developers/users/roles-ctrl/roles.php`, "get"),
    refetchOnWindowFocus: false,
  });

  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/users/system/system-users.php?id=${itemEdit.sysuser_aid}`
          : `${apiVersion}/controllers/developers/users/system/system-users.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["system-users"] });
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
    sysuser_is_active: itemEdit ? itemEdit.sysuser_is_active : 1,
    sysuser_full_name: itemEdit ? itemEdit.sysuser_full_name : "",
    sysuser_email: itemEdit ? itemEdit.sysuser_email : "",
    sysuser_role_id: itemEdit ? itemEdit.sysuser_role_id : "",
    sysuser_email_old: itemEdit ? itemEdit.sysuser_email : "",
  };

  const yupSchema = Yup.object({
    sysuser_full_name: Yup.string().trim().required("Required"),
    sysuser_email: Yup.string()
      .trim()
      .email("Invalid email")
      .required("Required"),
    sysuser_role_id: Yup.string().required("Required"),
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
        className="transition-all ease-in-out transform duration-200 "
      >
        {/* Modal header */}
        <div className="modal-header relative mb-4">
          <h3 className="text-dark text-sm">
            {itemEdit ? "Update" : "Add"} System User
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
                    {/* Active checkbox */}
                    <div className="flex items-center gap-2 mb-6">
                      <Field
                        type="checkbox"
                        name="sysuser_is_active"
                        id="sysuser_is_active"
                        className="!h-4 !w-4 accent-primary"
                        checked={props.values.sysuser_is_active == 1}
                        onChange={(e) =>
                          props.setFieldValue(
                            "sysuser_is_active",
                            e.target.checked ? 1 : 0,
                          )
                        }
                        disabled={mutation.isPending}
                      />
                      <label
                        htmlFor="sysuser_is_active"
                        className="!relative !transform-none !translate-y-0 !translate-x-0 !left-0 !top-0 !text-primary cursor-pointer"
                      >
                        Active
                      </label>
                    </div>

                    {/* Full Name */}
                    <div className="relative mb-6">
                      <InputText
                        label="Full Name"
                        name="sysuser_full_name"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Email */}
                    <div className="relative mb-6">
                      <InputText
                        label="Email"
                        name="sysuser_email"
                        type="email"
                        disabled={mutation.isPending}
                      />
                    </div>

                    {/* Role */}
                    <div className="relative mb-6">
                      <label
                        htmlFor="sysuser_role_id"
                        className="text-xs text-primary transform -translate-y-6 -translate-x-1 absolute left-3 top-4 px-1 z-10 isolate"
                      >
                        Role
                        <span className="content-[''] w-[97%] h-[2.5px] absolute left-px top-[7.2px] bg-white -z-10"></span>
                      </label>
                      <Field
                        as="select"
                        id="sysuser_role_id"
                        name="sysuser_role_id"
                        disabled={mutation.isPending}
                        className="block border border-solid border-gray-300 py-0.5 rounded-lg w-full bg-transparent outline-none focus:border-primary pt-2"
                      >
                        <option value="">-- Select Role --</option>
                        {rolesData?.data?.map((role) => (
                          <option key={role.role_aid} value={role.role_aid}>
                            {role.role_name}
                          </option>
                        ))}
                      </Field>
                      {props.errors.sysuser_role_id && props.touched.sysuser_role_id && (
                        <span className="text-red-500 text-xs">
                          {props.errors.sysuser_role_id}
                        </span>
                      )}
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

export default ModalAddSystemUsers;
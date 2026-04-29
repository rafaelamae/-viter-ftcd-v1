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
const ModalAddOtherUsers = ({ itemEdit }) => {
  const { store, dispatch } = React.useContext(StoreContext);
  const queryClient = useQueryClient();

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
          ? `${apiVersion}/controllers/developers/users/other/other-users.php?id=${itemEdit.otheruser_aid}`
          : `${apiVersion}/controllers/developers/users/other/other-users.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["other-users"] });
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
    otheruser_is_active: itemEdit ? itemEdit.otheruser_is_active : 1,
    otheruser_full_name: itemEdit ? itemEdit.otheruser_full_name : "",
    otheruser_email: itemEdit ? itemEdit.otheruser_email : "",
    otheruser_role_id: itemEdit ? itemEdit.otheruser_role_id : "",
    otheruser_email_old: itemEdit ? itemEdit.otheruser_email : "",
  };

  const yupSchema = Yup.object({
    otheruser_full_name: Yup.string().trim().required("Required"),
    otheruser_email: Yup.string()
      .trim()
      .email("Invalid email")
      .required("Required"),
    otheruser_role_id: Yup.string().required("Required"),
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
        className="transition-all ease-in-out transform duration-200 py-12 pl-6"
      >
        <div className="modal-header relative mb-4">
          <h3 className="text-dark text-sm">
            {itemEdit ? "Update" : "Add"} Other User
          </h3>
          <button
            type="button"
            className="absolute top-0 right-4"
            onClick={handleClose}
          >
            <FaTimes />
          </button>
        </div>

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
                    <div className="flex items-center gap-2 mb-6">
                      <Field
                        type="checkbox"
                        name="otheruser_is_active"
                        id="otheruser_is_active"
                        className="!h-4 !w-4 accent-primary"
                        checked={props.values.otheruser_is_active == 1}
                        onChange={(e) =>
                          props.setFieldValue(
                            "otheruser_is_active",
                            e.target.checked ? 1 : 0,
                          )
                        }
                        disabled={mutation.isPending}
                      />
                      <label
                        htmlFor="otheruser_is_active"
                        className="!relative !transform-none !translate-y-0 !translate-x-0 !left-0 !top-0 !text-primary cursor-pointer"
                      >
                        Active
                      </label>
                    </div>

                    <div className="relative mb-6">
                      <InputText
                        label="Full Name"
                        name="otheruser_full_name"
                        type="text"
                        disabled={mutation.isPending}
                      />
                    </div>

                    <div className="relative mb-6">
                      <InputText
                        label="Email"
                        name="otheruser_email"
                        type="email"
                        disabled={mutation.isPending}
                      />
                    </div>

                    <div className="relative mb-6">
                      <label
                        htmlFor="otheruser_role_id"
                        className="text-xs text-primary transform -translate-y-6 -translate-x-1 absolute left-3 top-4 px-1 z-10 isolate"
                      >
                        Role
                        <span className="content-[''] w-[97%] h-[2.5px] absolute left-px top-[7.2px] bg-white -z-10"></span>
                      </label>
                      <Field
                        as="select"
                        id="otheruser_role_id"
                        name="otheruser_role_id"
                        disabled={mutation.isPending}
                        className="block border border-solid border-gray-300 p-0.5 rounded-lg w-full bg-transparent outline-none focus:border-primary pt-2"
                      >
                        <option value="">-- Select Role --</option>
                        {rolesData?.data?.map((role) => (
                          <option key={role.role_aid} value={role.role_aid}>
                            {role.role_name}
                          </option>
                        ))}
                      </Field>
                      {props.errors.otheruser_role_id && props.touched.otheruser_role_id && (
                        <span className="text-red-500 text-xs">
                          {props.errors.otheruser_role_id}
                        </span>
                      )}
                      {store.error && <MessageError />}
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
        </div>
      </ModalWrapperSide>
    </>
  );
};

export default ModalAddOtherUsers;
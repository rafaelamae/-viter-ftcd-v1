import React from "react";
import { StoreContext } from "../../../../store/StoreContext";
import * as Yup from "yup";
import { useMutation, useQueryClient } from "@tanstack/react-query";
import { queryData } from "../../../../functions/custom-hooks/queryData";
import useQueryData from "../../../../functions/custom-hooks/useQueryData";
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

const ModalAddDesignation = ({ itemEdit }) => {
  const { dispatch } = React.useContext(StoreContext);
  const queryClient = useQueryClient();

  const {
    data: category,
    isLoading: isCategoryLoading,
    isFetching: isCategoryFetching,
  } = useQueryData(
    `${apiVersion}/controllers/developers/settings/category/category.php`,
    "get",
    "category-active",
  );

  const mutation = useMutation({
    mutationFn: (values) =>
      queryData(
        itemEdit
          ? `${apiVersion}/controllers/developers/settings/designation/designation.php?id=${itemEdit.des_aid}`
          : `${apiVersion}/controllers/developers/settings/designation/designation.php`,
        itemEdit ? "put" : "post",
        values,
      ),
    onSuccess: (data) => {
      queryClient.invalidateQueries({ queryKey: ["designation"] });
      queryClient.invalidateQueries({ queryKey: ["designation-active"] });
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
    des_is_active: itemEdit ? itemEdit.des_is_active : 1,
    des_name: itemEdit ? itemEdit.des_name : "",
    des_category_id: itemEdit ? itemEdit.des_category_id : "",
  };

  const yupSchema = Yup.object({
    des_name: Yup.string().trim().required("Required"),
    des_category_id: Yup.string().required("Required"),
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
            {itemEdit ? "Update" : "Add"} Designation
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
                      name="des_name"
                      type="text"
                      disabled={mutation.isPending}
                    />
                  </div>

                  <div className="relative mb-8">
                    <Field
                      as="select"
                      id="des_category_id"
                      name="des_category_id"
                      disabled={
                        mutation.isPending ||
                        isCategoryLoading ||
                        isCategoryFetching
                      }
                      className="h-[35px] border border-solid border-gray-300 p-2 rounded-lg w-full bg-transparent outline-none focus:border-primary"
                    >
                      <option value=""></option>
                      {category?.data?.map((item) => (
                        <option value={item.cat_aid} key={item.cat_aid}>
                          {item.cat_name}
                        </option>
                      ))}
                    </Field>
                    <label htmlFor="des_category_id">
                      <span className="text-alert">*</span>Category
                    </label>
                    {props.touched.des_category_id &&
                      props.errors.des_category_id ? (
                      <span className="error-show">
                        {props.errors.des_category_id}
                      </span>
                    ) : null}
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

export default ModalAddDesignation;

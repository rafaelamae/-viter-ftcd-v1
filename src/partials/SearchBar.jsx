import { setError, setIsSearch, setMessage } from "../store/StoreAction";
import { FaSearch } from "react-icons/fa";

const SearchBar = ({
  search,
  dispatch,
  store,
  result,
  isFetching,
  setOnSearch,
  onSearch,
  isFilter = false,
  label = "Search here...",
  className = "",
  variant = "default",
}) => {
  const handleChange = (e) => {
    if (e.target.value === "") {
      setOnSearch(!onSearch);
      dispatch(setIsSearch(false));
    }
    if (isFilter === true) {
      dispatch(setIsSearch(true));
    }
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    let val = search.current.value;

    if (val === " " || val === "") {
      setOnSearch(!onSearch);
      dispatch(setIsSearch(false));
      dispatch(setError(true));
      dispatch(setMessage("Search keyword cannot be space only or blank."));
    } else {
      setOnSearch(!onSearch);
      dispatch(setIsSearch(true));
    }
  };

  return (
    <form
      onSubmit={(e) => {
        handleSubmit(e);
      }}
      className="search-box"
    >
      <div className={`${className} items-center relative`}>
        {variant === "users" ? (
          <>
            <input
              type="search"
              placeholder={label}
              className="text-xs h-8 pl-3 pr-12 rounded-md"
              ref={search}
              onChange={(e) => handleChange(e)}
            />
            <button
              type="submit"
              className="absolute right-0 top-0 flex h-8 w-10 items-center justify-center rounded-r-md bg-primary text-white"
            >
              <FaSearch />
            </button>
          </>
        ) : (
          <>
            <span
              type="submit"
              className="absolute left-2 top-1.5 text-sm h-9 py-[3px] rounded-tr-none rounded-br-none border-l-0 text-gray-400 cursor-default "
            >
              <FaSearch />
            </span>
            <input
              type="search"
              placeholder={label}
              className="text-xs h-8 pl-7"
              ref={search}
              onChange={(e) => handleChange(e)}
            />
          </>
        )}
      </div>
    </form>
  );
};

export default SearchBar;

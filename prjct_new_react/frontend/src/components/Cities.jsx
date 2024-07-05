import React from "react";
import { getAllUsers } from "../helpers/user.helpers";
import { useState, useEffect } from "react";
import { formatDateToView } from "../helpers/helpers";
import { adminCitySearch, getAllCities } from "../helpers/activity.helpers";
import { Avatar } from "@mui/material";
import { AddCityModal } from "./modals/AddCityModal";
import SuccessMessageComponent from "./SuccessComponent";
import ErrorMessageComponent from "./ErrorComponent";
import { useNavigate } from "react-router-dom";

export const Cities = () => {
  const [cities, setCities] = useState();
  const [selectedCity, setSelectedCity] = useState();
  const [cityFormData, setCityFormData] = useState("");
  const [isOpen, setIsOpen] = useState(false);
  const [isOpenAdd, setIsOpenAdd] = useState(false);
  const [successMessage, setSuccessMessage] = useState("");
  const [errorMessage, setErrorMessage] = useState("");

  const openModal = () => {
    setIsOpen(true);
  };
  const openModalAdd = () => {
    setIsOpenAdd(true);
  };

  const onRequestClose = () => {
    setIsOpen(false);
  };
  const onRequestCloseAdd = () => {
    setIsOpenAdd(false);
  };

  const clearMessage = () => {
    setErrorMessage("");
    setSuccessMessage("");
  };

  const handleInputChange = (e) => {
    setCityFormData(e.target.value);
    search(cityFormData);
  };

  const navigate = useNavigate();

  const search = async (query) => {
    try {
      const res = await adminCitySearch(query);
      console.log(res);
      if (res.data.status === "success") {
        setCities(res.data.cities);
        console.log(cities);
      }
    } catch (error) {
      console.log(error);
      setErrorMessage(error);
    }
  };

  useEffect(() => {
    search(cityFormData);
  }, [cityFormData]);

  return (
    <div className="flex-col pb-10 w-full  ">
      <div className="flex p-5  cursor-default items-center text-black justify-between ">
        <div className="flex items-center justify-start w-full ">
          <h4 className="font-bold  uppercase">Cities</h4>
        </div>
        <div className=" w-full flex justify-center items-center">
          <input
            type="text"
            name="cities"
            placeholder="Search Cities..."
            value={cityFormData}
            onChange={handleInputChange}
            autoComplete="off"
            className="m-3 placeholder:text-[#4F5D75] bg-transparent px-3 py-1 text-base w-full border-b-2 border-b-gray-800 outline-none transition-all focus:border-b-[#4F5D75]"
          />
        </div>
        <div className="flex items-center justify-end w-full ">
          <button className="text-sm hover:border-b-2 hover:border-gray-700 border-b-2 border-gray-100 transition-all">
            <h4 onClick={() => setIsOpenAdd(true)}>Add New</h4>
          </button>
        </div>
      </div>

      <div className="flex flex-wrap justify-center  bg-gray-600 rounded-lg py-10 gap-5  cursor-default  shadow-lg  text-black ">
        {cities?.length === 0 && cityFormData !== "" ? (
          <div>no results</div>
        ) : (
          cities?.map((city) => (
            <div
              onClick={() => {
                console.log(city);
                navigate(`/city/${city?.id}`);
              }}
              key={city?.id}
              className="flex flex-col   p-28 rounded-lg gap-8 overflow-hidden  hover:bg-slate-100 hover:shadow-2xl hover:scale-110 transition-all cursor-pointer "
            >
              <Avatar
                className="shadow-2xl"
                sx={{ width: 170, height: 170 }}
                src={`http://127.0.0.1:8000/api/profile/${city?.id}/${city?.picture}`}
              ></Avatar>
              <div className="flex  bg-white justify-center rounded-xl shadow-lg ">
                <p className=" font-bold  text-md uppercase ">
                  {city?.city_name}
                </p>
              </div>
            </div>
          ))
        )}
      </div>

      <AddCityModal
        isOpen={isOpenAdd}
        onRequestClose={onRequestCloseAdd}
        updateCities={search}
        setSuccess={setSuccessMessage}
        setError={setErrorMessage}
      />
      {successMessage && (
        <SuccessMessageComponent
          clearMessage={clearMessage}
          message={successMessage}
        />
      )}
      {errorMessage && (
        <ErrorMessageComponent
          clearMessage={clearMessage}
          message={errorMessage}
        />
      )}
    </div>
  );
};

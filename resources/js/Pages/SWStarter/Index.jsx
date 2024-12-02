import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import { Head, router } from "@inertiajs/react";
import { useState } from "react";
import Results from "./Results";

export default function Index({ resultData = [], search, resultType }) {
    const [searchType, setSearchType] = useState(resultType ?? "");
    const [searchText, setSearchText] = useState(search ?? "");
    const [loadingData, setLoadingData] = useState(false);

    const inputHandler = (event) => {
        setSearchText(event.target.value);
    };

    const searchHandler = () => {
        async function search() {
            setLoadingData(true);
            await router.get("/sw-starter", {
                type: searchType,
                search: searchText,
            });
        }
        search();
    };

    return (
        <AuthenticatedLayout
            header={
                <div className="text-xl text-center font-semibold leading-tight text-lawn-green">
                    SWStarter
                </div>
            }
        >
            <Head title="SW Starter" />

            <div className="py-12">
                <div className="grid grid-cols-9">
                    <div className="col-start-2 col-span-3">
                        <div className="max-w-7xl sm:px-6 lg:px-8">
                            <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div className="p-6 text-gray-900">
                                    <div className="text-xl font-bold m-3">
                                        What are you searching for?
                                    </div>
                                    <div className="flex inline-flex items-center">
                                        <div className="m-4">
                                            <input
                                                onChange={(e) =>
                                                    setSearchType("people")
                                                }
                                                checked={
                                                    searchType === "people"
                                                }
                                                id="default-radio-1"
                                                type="radio"
                                                value="people"
                                                name="default-radio"
                                            />
                                            <label
                                                htmlFor="default-radio-1"
                                                className="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >
                                                People
                                            </label>
                                        </div>
                                        <div className="flex items-center">
                                            <input
                                                onChange={(e) =>
                                                    setSearchType("films")
                                                }
                                                checked={searchType === "films"}
                                                id="default-radio-2"
                                                type="radio"
                                                value="films"
                                                name="default-radio"
                                            />
                                            <label
                                                htmlFor="default-radio-2"
                                                className="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                            >
                                                Movies
                                            </label>
                                        </div>
                                    </div>
                                    <div>
                                        <TextInput
                                            className="w-full"
                                            placeholder={
                                                searchType === "films"
                                                    ? "e.g. Return of the Jedi"
                                                    : "e.g. Chewbacca, Yoda, Boba Fett"
                                            }
                                            value={searchText}
                                            onChange={inputHandler}
                                        ></TextInput>
                                    </div>
                                    <div className="my-4">
                                        <PrimaryButton
                                            className="w-full"
                                            onClick={searchHandler}
                                            disabled={
                                                loadingData ||
                                                !searchText.length
                                            }
                                        >
                                            {loadingData
                                                ? "SEARCHING..."
                                                : "SEARCH"}
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <Results
                        loadingData={loadingData}
                        resultData={resultData}
                        searchType={searchType}
                    ></Results>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

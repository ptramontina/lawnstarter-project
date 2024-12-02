import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link } from "@inertiajs/react";
import PeopleList from "./PeopleList";
import MovieList from "./MovieList";
import PrimaryButton from "@/Components/PrimaryButton";

export default function Show({ details, type }) {
    return (
        <AuthenticatedLayout
            header={
                <h2 className="text-xl text-center font-semibold leading-tight text-lawn-green">
                    SWStarter
                </h2>
            }
        >
            <Head title="SW Starter" />

            <div className="py-12">
                <div className="grid grid-cols-8">
                    <div className="col-start-3 col-span-4">
                        <div className="mx-auto max-w-7xl sm:px-6 lg:px-8">
                            <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                                <div className="p-6 text-gray-900">
                                    <div className="font-semibold text-2xl">
                                        {type === "films"
                                            ? details.title
                                            : details.name}
                                    </div>

                                    <div className="flex mb-4">
                                        {type === "films" ? (
                                            <MovieList
                                                details={details}
                                            ></MovieList>
                                        ) : (
                                            <PeopleList
                                                details={details}
                                            ></PeopleList>
                                        )}
                                    </div>
                                    <div className="">
                                        <Link href="/sw-starter">
                                            <PrimaryButton>
                                                BACK TO SEARCH
                                            </PrimaryButton>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

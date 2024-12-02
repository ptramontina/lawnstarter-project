import List from "./List";

export default function Results({ loadingData, resultData, searchType }) {
    return (
        <div className="col-start-5 col-span-4">
            <div className="max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div className="p-6 text-gray-900">
                        <div className="text-2xl font-bold m-3">Results</div>
                        <hr></hr>

                        {loadingData && (
                            <div className="flex h-96">
                                <div className="m-auto font-bold text-center text-gray-400 text-xl">
                                    <div>Searching...</div>
                                </div>
                            </div>
                        )}

                        {!loadingData && !resultData.length && (
                            <div className="flex h-96">
                                <div className="m-auto font-bold text-center text-gray-400 text-xl">
                                    <div>There are zero matches</div>
                                    <div>
                                        Use the form to search for People or
                                        Movies
                                    </div>
                                </div>
                            </div>
                        )}

                        {!loadingData && !!resultData.length && (
                            <List list={resultData} type={searchType}></List>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
}

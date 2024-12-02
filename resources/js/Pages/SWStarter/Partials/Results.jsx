import FullBox from "./FullBox";
import List from "./List";

export default function Results({ loadingData, resultData, searchType }) {
    return (
        <div className="col-start-5 col-span-4">
            <div className="max-w-7xl sm:px-6 lg:px-8">
                <div className="overflow-hidden bg-white shadow rounded">
                    <div className="p-6 text-gray-900">
                        <div className="text-2xl font-bold m-3">Results</div>
                        <hr></hr>

                        {loadingData && <FullBox>Searching...</FullBox>}

                        {!loadingData && !resultData.length && (
                            <FullBox>
                                <div>There are zero matches</div>
                                <div>
                                    Use the form to search for People or Movies
                                </div>
                            </FullBox>
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

import { Link } from "@inertiajs/react";
import PrimaryButton from "@/Components/PrimaryButton";

export default function List({ list, type }) {
    return (
        <div className="m-2">
            {list.map((item) => (
                <div key={item.url}>
                    <div className="grid grid-cols-2 m-2">
                        <div className="mt-1">
                            {type === "films" ? item.title : item.name}
                        </div>
                        <div className="text-right">
                            <Link
                                href="sw-starter/show"
                                data={{ type, url: item.url }}
                            >
                                <PrimaryButton>Details</PrimaryButton>
                            </Link>
                        </div>
                    </div>
                    <hr />
                </div>
            ))}
        </div>
        // {{item.url}
        // <p className="">{item.name}</p>
        // <p className="">
        //     <Link
        //         href="sw-starter/show"
        //         data={{ type, url: item.url }}
        //     >
        //         <PrimaryButton>Details</PrimaryButton>
        //         Details
        //     </Link>
        // </p>}
    );
}

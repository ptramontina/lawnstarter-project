import { Link } from "@inertiajs/react";

export default function PeopleList({ details, type }) {
    const list = details.films?.map((film) => {
        return (
            <span key={film.id} className="mx-px hover:underline">
                <Link
                    href="/sw-starter/show"
                    data={{ type: "films", id: film.id }}
                >
                    {film.title},
                </Link>
            </span>
        );
    });

    return (
        <>
            <div className="w-1/2 m-4 p-2">
                <div className="font-semibold text-xl">Details</div>
                <hr />
                <div className="m-2">
                    <div>Birth year: {details.birth_year}</div>
                    <div>Gender: {details.gender}</div>
                    <div>Eye Color: {details.eye_color}</div>
                    <div>Hair Color: {details.hair_color}</div>
                    <div>Height: {details.hair_color}</div>
                    <div>Mass: {details.mass}</div>
                </div>
            </div>
            <div className="w-1/2 m-4 p-2">
                <div className="font-semibold text-xl">Movies</div>
                <hr />
                <div className="m-2">{list}</div>
            </div>
        </>
    );
}

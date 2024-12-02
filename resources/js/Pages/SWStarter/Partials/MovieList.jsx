import { Link } from "@inertiajs/react";

export default function MovieList({ details }) {
    const openingCrawl = details.opening_crawl
        .split("\n\r")
        .map((paragraph, index) => (
            <div key={index}>
                <div>
                    {paragraph.split("\r\n").map((line, index) => (
                        <div key={index}>{line}</div>
                    ))}
                </div>
                <br />
            </div>
        ));

    const list = details.characters?.map((character) => {
        return (
            <span key={character.id} className="mx-px hover:underline">
                <Link
                    href="/sw-starter/show"
                    data={{ type: "people", id: character.id }}
                >
                    {character.name},
                </Link>
            </span>
        );
    });

    return (
        <>
            <div className="w-1/2 m-4 p-2">
                <div className="font-semibold text-xl">Opening Crawl</div>
                <hr />
                <div className="m-2">{openingCrawl}</div>
            </div>
            <div className="w-1/2 m-4 p-2">
                <div className="font-semibold text-xl">Characters</div>

                <hr />
                <div className="m-2">{list}</div>
            </div>
        </>
    );
}

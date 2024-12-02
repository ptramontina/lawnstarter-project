export default function FullBox({ children }) {
    return (
        <div className="flex h-96">
            <div className="m-auto font-bold text-center text-gray-400 text-lg">
                <div>{children}</div>
            </div>
        </div>
    );
}

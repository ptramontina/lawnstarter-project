export default function PrimaryButton({
    className = "",
    disabled,
    children,
    ...props
}) {
    return (
        <button
            {...props}
            className={
                `rounded-full border border-transparent bg-lawn-green px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-opacity-80 focus:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-opacity-80 ${
                    disabled && "disabled:bg-gray-300"
                } ` + className
            }
            disabled={disabled}
        >
            <div className="text-center">{children}</div>
        </button>
    );
}

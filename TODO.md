Use Laravel Pipeline
Use Webmozart Assert instead of assertion validations
Use Laravel Collection
Dont depend on whole Laravel and only depend on specific packages and versions
    for example, use Collection from Laravel 5.8
Augument Laravel facades using Laravel Macros
Protected params are used all over the place. Use Value Objects instead or move away from using
    protected param and use public param instead or make the private
Simplify codes. Someone should be able to read the code and understand what it does
    without having to read the comments. Take inspiration from Laravel codebase
Move code to where it belongs. For example, if a method is used only in a specific class, move it to that class
    instead of having it in a helper file. Move related methods closer to each other
    Move stuff in the classes where they belong.
Typehint everything. Use PHP 7.4 features
    Move away from docblocks as much as possible
Use Attributes where possible
Dont use our InvalidArgumentException, either use Webmozart Assert or use PHP's built-in \InvalidArgumentException
Dont use any string, make intentions clear. Use Objects!
Move away from using static methods. Use Dependency Injection instead
Go through TODOs and FIXMEs and fix them
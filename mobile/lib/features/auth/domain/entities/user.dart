class User {
  final int id;
  final String name;
  final String email;
  final String role;
  final String? profilePhotoUrl;

  User({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
    this.profilePhotoUrl,
  });
}
